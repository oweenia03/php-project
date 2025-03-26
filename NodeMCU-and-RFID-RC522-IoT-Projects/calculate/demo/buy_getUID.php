<?php
// UID를 POST 요청으로 받아옴
if (isset($_POST['uid'])) {
    $UIDresult = $_POST['uid'];

    // UID를 저장할 UIDcontainer.php 파일 경로 지정
    $container_file = 'buy_UIDcontainer.php';

    // 기존 UID를 읽어옴
    $existing_UIDs = [];
    if (file_exists($container_file)) {
        include($container_file); // 기존 파일에서 UID 배열 불러오기
        if (isset($UIDs)) {
            $existing_UIDs = $UIDs; // 기존 UID 배열
        }
    }

    // 새로운 UID를 배열에 추가
    $existing_UIDs[] = $UIDresult;

    // UIDcontainer.php 파일에 UID 배열 저장
    $Write = "<?php $" . "UIDs = " . var_export($existing_UIDs, true) . "; ?>";
    file_put_contents($container_file, $Write);

    // 성공 메시지 출력
    echo "UID received and stored successfully: " . $UIDresult;
} else {
    echo "No UID data received.";
}
?>
