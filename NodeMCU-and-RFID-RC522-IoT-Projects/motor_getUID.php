<?php
// UID를 POST 요청으로 받아옴
if (isset($_POST['uid'])) {
    $UIDresult = $_POST['uid'];

    // UID를 저장할 UIDcontainer.php 파일 경로 지정
    $container_file = 'motor_UIDcontainer.php';

    // UIDcontainer.php 파일에 UID 저장
    $Write = "<?php $" . "UIDresult='" . $UIDresult . "'; " . "echo $" . "UIDresult;" . " ?>";
    file_put_contents($container_file, $Write);

    // 성공 메시지 출력
    echo "UID received and stored successfully: " . $UIDresult;
} else {
    echo "No UID data received.";
}
?>
