<?php
require '../../database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_POST['uid']; // 단일 UID를 POST로 받아옴

    // UID 유효성 검사
    if (empty($uid)) {
        echo json_encode(["error" => "유효하지 않은 UID입니다."]);
        exit();
    }

    $pdo = Database::connect();

    // UID를 사용하여 stock_status를 'Y'로 업데이트
    $sqlUpdate = "UPDATE table_the_iot_projects SET stock_status = 'Y' WHERE uid = ?"; // uid 필드 사용
    
    try {
        $uid = trim($uid); // 입력값 정리
        if (!empty($uid)) { // 빈 UID는 처리하지 않도록 추가 검증
            $qUpdate = $pdo->prepare($sqlUpdate);
            $qUpdate->execute(array($uid)); // 각 UID의 stock_status 필드 값 수정
        }

        // 성공적인 업데이트 후 메시지 반환
        echo json_encode(["message" => "성공적으로 업데이트되었습니다."]);
    } catch (PDOException $e) {
        // 에러 처리
        echo json_encode(["error" => "오류 발생: " . $e->getMessage()]);
    } finally {
        Database::disconnect();
    }
}
?>
