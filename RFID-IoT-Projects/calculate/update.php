<?php
require '../database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_POST['uid']; // UID를 POST로 받아옴

    // UID 유효성 검사 (예: 문자열이 비어있지 않아야 함)
    if (empty($uid)) {
        echo "유효하지 않은 UID입니다.";
        exit();
    }

    $pdo = Database::connect();

    // stock_status를 'Y'로 업데이트
    $sqlUpdate = "UPDATE table_the_iot_projects SET stock_status = 'Y' WHERE id = ?";
    
    try {
        $qUpdate = $pdo->prepare($sqlUpdate);
        $qUpdate->execute(array($uid)); // 해당 UID의 stock_status 필드 값 수정

        // 성공적인 업데이트 후 메시지 반환
        echo "성공적으로 업데이트되었습니다.";
    } catch (PDOException $e) {
        // 에러 처리
        echo "오류 발생: " . $e->getMessage();
        Database::disconnect();
        exit();
    }

}
?>
