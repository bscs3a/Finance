<?php 

require_once './src/dbconn.php';


function addAccountantAuditLog($action) {
    // Get PDO Instance
    $db = Database::getInstance();
    $pdo = $db->connect();

    $employee_name = $_SESSION['employee_name'];

    // Query
    $sql = "INSERT INTO tbl_fin_audit (employee_name, action, created_at) VALUES (:employee_name, :action, current_timestamp())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':employee_name', $employee_name);
    $stmt->bindParam(':action', $action);
    $stmt->execute();
}




?>