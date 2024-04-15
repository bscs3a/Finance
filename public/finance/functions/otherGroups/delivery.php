<?php
// public\finance\functions\otherGroups\delivery.php

// Sample Data
const DEPARTMENT = 'Delivery';
const DEPARTMENT_ID = '2';
const FUEL_LEDGER_NO = '16';
const COH_LEDGER_NO_DR = '1';
const TRANSACTION_DETAILS = "Fuel/Gas";



// SQL Schema Copy and Paste
// CREATE TABLE tbl_department (
//     department_id INT AUTO_INCREMENT PRIMARY KEY,
//     department_name VARCHAR(50) NOT NULL
// );

// INSERT INTO tbl_department (department_name)
// VALUES ('Human Resource'),
// ('Delivery/Dispatcher'),
// ('Sales'),
// ('Product Order'),
// ('Inventory'),
// ('Finance/Accounting')
// ;

// SELECT * FROM tbl_department;


// CREATE TABLE tbl_record_per_department (
//     record_per_department_id INT AUTO_INCREMENT PRIMARY KEY,
//     fk_LedgerXactID INT NOT NULL,
//     fk_department_id INT NOT NULL,

//     FOREIGN KEY (fk_LedgerXactID) REFERENCES ledgertransaction(LedgerXactID),
//     FOREIGN KEY (fk_department_id) REFERENCES tbl_department(department_id)

// );


/*
@author: Rokhai
@department: STRING user department
@details: STRING details of the transactio
@payUsing: STRING mode of payment such Cash on Hand, Cash on Bank
@payFor: STRING what you are paying for in the transaction
$amount: INT amount of the transaction
*/
function insertDeliveryExpense($department = "", $details = "",$payUsing = "", $payFor = "", $amount) {

    if (!checkDepartment($department)) 
        throw new Exception("Department does not exist");
    if ($amount <= 0)
        throw new Exception("Amount must be greated than 0");
    if ($details === null || $details === "")
        throw new Exception("Details cannot be empty");
    if (!deliveryCheckPayFor($payFor)) 
        throw new Exception("Pay for cannot be null");
    if (!checkPayUsing($payUsing))
        throw new Exception("Pay using cannot be null");

    $db = Database::getInstance();
    $conn = $db->connect();

    try {
        // Start the transaction
        $conn->beginTransaction();
    
        $sqlLedgerTransaction = "INSERT INTO ledgertransaction (LedgerNo, LedgerNo_Dr, amount, details)
                                VALUES (?, ?, ?, ?)";
    
        $stmt = $conn->prepare($sqlLedgerTransaction);
        $isFuelGas = $stmt->execute([$payFor, $payUsing, $amount, $details]);
    
        if (!$isFuelGas) {
            throw new Exception('Transaction Unsuccessful');
        }
    
        $sqlRecordPerDept = "INSERT INTO tbl_record_per_department (fk_LedgerXactID, fk_department_id)
                            VALUES (last_insert_id(), ?)";
        $stmt = $conn->prepare($sqlRecordPerDept);
        $isDepartmentRecord = $stmt->execute([DEPARTMENT_ID]);

        if(!$isDepartmentRecord) 
            throw new Exception('Unsuccesfully record per department');

        // If we've reached this point, all queries were successful. Commit the transaction.
        $conn->commit();
    } catch (Exception $e) {
        // An error occurred; roll back the transaction
        $conn->rollback();
    
        // Re-throw the exception so it can be caught and handled outside the transaction
        throw $e;
    }

    return true;
}

// check pay for
function deliveryCheckPayFor($payFor) {
    $valid = getDeliveryValidPayFor();
    if (in_array($payFor, $valid))
        return true;
    return false;
}

// check valid pay
// Valid list are Fuel/Gas, Maintenance and Repairs, Miscellaneous
function getDeliveryValidPayFor() {
    $valid = [];
    $notInclude = getNotInclude();
    $fuelAndGas = getDeliveryLedgerCode('Fuel and Gas');
    $maintenanceAndRepairs = getDeliveryLedgerCode('Maintenance and Repairs');
    $miscellaneous = getDeliveryLedgerCode('Miscellaneous');

    $db = Database::getInstance();
    $conn = $db->connect();
    $notIncludePlaceholders = implode(',', array_fill(0, count($notInclude), '?'));

    $sql = "SELECT name FROM Ledger
            WHERE (ledgerno = ? OR ledgerno = ? OR ledgerno = ?)
            AND name NOT IN ($notIncludePlaceholders)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array_merge([$fuelAndGas, $maintenanceAndRepairs, $miscellaneous], $notIncludePlaceholders));

    while ($row = $stmt->fetch()) {
        $valid[] = $row['name'];
    }

    return $valid;

}

// check ledger code for delivery department only
function getDeliveryLedgerCode($ledgerName) {
    if ($ledgerName === null)
        return false;

    $db = Database::getInstance();
    $conn = $db->connect();
    $sql = "SELECT ledgerno FROM ledger WHERE name = :ledgerName";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':ledgerName', $ledgerName);
    $stmt->execute();
    $ledgerCode = $stmt->fetchColumn();

    return $ledgerCode;

}
// check department
function checkDepartment($department){
    $validDepartments = ["Delivery", "Finance", "Human Resource", "Inventory", "Product Order", "Sales"];
    if (in_array($department, $validDepartments)) {
        return true;
    }
    return false;
}


// check pay using
function checkPayUsing($payusing){
    $valid = ["Cash on hand" , "Cash on bank"];
    if (in_array($payusing, $valid)) {
        return true;
    }
    return false;
}
?>