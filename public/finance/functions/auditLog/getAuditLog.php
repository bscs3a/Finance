<?php 

require_once './../../../../src/dbconn.php';

function getAccountantAuditLog() {
    // Get PDO Instance
    $db = Database::getInstance();
    $pdo = $db->connect();


    $employee_name = $_SESSION['employee_name'];

    // Query for audit logs
    $sql = "SELECT * FROM tbl_fin_audit WHERE employee_name = :employee_name";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':employee_name', $employee_name);
    $stmt->execute();
    $auditLogs = $stmt->fetchAll(PDO::FETCH_COLUMN);

    return ['auditLogs' => $auditLogs];
}

?>