<?php
  
  $uname = $_POST['uname'];
  $phone = $_POST['phone'];
  $gender = $_POST['gender'];
  $birth = $_POST['birth'];

  //DB연결
  $dbcon = mysqli_connect('localhost', 'root', '');

  //DB선택
  mysqli_select_db($dbcon, 'myDB');
  
  error_reporting(E_ALL);
  ini_set("display_errors", 1);

  //DB 쿼리
  $query = "insert into user values (null, '$uname', '$phone', '$gender', '$birth')";
  
  //쿼리가 정상적으로 실행되면 if문 실행
  $check = mysqli_query($dbcon, $query);
  if ($check) echo "환영합니다. <b><i>$uname</i></b> 님의 정보가 잘 입력되었습니다.";
  else        echo "DB오류가 발생하였습니다. 관리자에게 문의하세요.";
  
  //DB연결 종료
  mysqli_close($dbcon);
?>