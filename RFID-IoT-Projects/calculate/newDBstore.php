<?php
// 데이터베이스 연결 정보
$servername = "localhost";  // 데이터베이스 서버 주소
$username = "root";         // MySQL 사용자 이름
$password = "0107";         // MySQL 비밀번호
$dbname = "tagged_products_db";  // 사용할 데이터베이스 이름

// 데이터베이스 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 사용자가 입력한 데이터를 안전하게 처리
$uid = $conn->real_escape_string($_GET['id']);

// 기존 테이블에서 정보를 가져오는 쿼리 (prepared statement 사용)
$sql = "SELECT * FROM table_the_iot_projects WHERE uid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $uid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
        // 정보 출력 코드
        echo "
        <table>
            <tr><td>ID</td><td>{$row['id']}</td></tr>
            <tr><td>Product Name</td><td>{$row['uname']}</td></tr>
            <tr><td>Price</td><td>{$row['price']}</td></tr>
            <tr><td>Expiration Date</td><td>{$row['Expiration']}</td></tr>
            <tr><td>Stock Status</td><td>{$row['stock_status']}</td></tr>
        </table>
    ";

    // 별도의 테이블에 저장하는 쿼리 (prepared statement 사용)
    $sql_insert = "INSERT INTO tagged_data (id, uname, price, Expiration, stock_status) 
               VALUES (?, ?, ?, ?, ?) 
               ON DUPLICATE KEY UPDATE stock_status = ?";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sssss", $row['id'], $row['uname'], $row['price'], $row['Expiration'], $row['stock_status']);
    $stmt_insert->execute();
} else{
    echo "No data found for the provided UID.";
}


// 연결 종료
$stmt->close();
$conn->close();
?>
