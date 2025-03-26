<?php
session_start();
session_unset();  // 세션 변수들을 해제
session_destroy();  // 세션을 파기
header("Location: login.php");  // 로그아웃 후 로그인 페이지로 이동
exit();
?>
