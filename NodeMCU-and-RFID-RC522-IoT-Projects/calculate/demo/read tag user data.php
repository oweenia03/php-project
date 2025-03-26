<?php
require '../../database.php';

// buy_UIDContainer.php에서 UID를 가져옴
require 'buy_UIDcontainer.php';  // UIDresult 변수를 가져옵니다.

$idList = []; // UIDresult를 idList로 변경하여 저장

if (!empty($UIDresult)) {
    // UIDresult가 비어 있지 않다면 idList에 추가
    if (is_array($UIDresult)) {
        $idList = array_merge($idList, $UIDresult); // UIDresult가 배열인 경우 병합
    } else {
        $idList[] = $UIDresult; // 단일 값인 경우 추가
    }
}

$uidList = $_POST['uidList'] ?? []; // UID 리스트 가져오기
$uidList = array_merge($uidList, $idList); // UIDresult를 UID 리스트에 병합

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$dataArray = []; // 결과를 저장할 배열 초기화

foreach ($uidList as $id) { // $id를 사용하여 각 UID에 대해 반복
    $sql = "SELECT uid AS id, uname, price, Expiration, stock_status FROM table_the_iot_projects WHERE id = ?"; // id 필드로 쿼리
    $q = $pdo->prepare($sql);
    $q->execute(array(trim($id))); // $id로 쿼리 실행
    $data = $q->fetch(PDO::FETCH_ASSOC);
    
    if ($data) {
        // 데이터가 있는 경우 배열에 추가
        $dataArray[] = [
            'id' => htmlspecialchars($data['id']),
            'uname' => htmlspecialchars($data['uname'] ?? "--------"),
            'price' => htmlspecialchars($data['price'] ?? "--------"),
            'Expiration' => htmlspecialchars($data['Expiration'] ?? "--------"),
            'stock_status' => htmlspecialchars($data['stock_status'] ?? "--------"),
        ];
    } else {
        // 데이터가 없는 경우 에러 메시지 추가
        $dataArray[] = [
            'id' => htmlspecialchars($id), // UID로 에러 메시지 표시
            'uname' => "The ID of your Card / KeyChain is not registered !!!",
            'price' => "",
            'Expiration' => "",
            'stock_status' => "",
        ];
    }
}

Database::disconnect();

// JSON 배열로 인코딩하여 출력
header('Content-Type: application/json');
echo json_encode($dataArray);
?>
