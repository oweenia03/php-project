<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'database.php';

if (!empty($_POST)) {
    // 입력값 추적 및 공백 제거 후 소문자로 변환
    $id = strtolower(trim($_POST['id'])); // 공백 제거 후 소문자로 변환
    $uname = $_POST['uname'];
    $price = $_POST['price'];
    $expiration = $_POST['expiration'];
    $stock_status = $_POST['stock_status'];
    
    try {
        // 데이터베이스 연결
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // SQL 쿼리
        $sql = "INSERT INTO table_the_iot_projects (id, uname, price, Expiration, stock_status) values(?, ?, ?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($id, $uname, $price, $expiration, $stock_status));
        
        Database::disconnect();
        header("Location: user data.php");
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage(); // 오류 메시지 출력
    }
}

?>