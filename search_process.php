<?php
  
  $uname = $_POST['uname'];
  $gender = $_POST['gender'];
  $count = 0;

  //DB연결
  $dbcon = mysqli_connect('localhost', 'root', '');
  
  //DB선택
  mysqli_select_db($dbcon, 'ktest');
  
  //DB 질의문
  if($uname and $gender !='all'){
    $query = "select * from user where uname like '%$uname%' and gender = '$gender'";
  } else if($uname and $gender == 'all'){
    $query = "select * from user where uname like '%$uname%'";
  } else if(!$uname and $gender != 'all'){
    $query = "select * from user where gender = '$gender'";
  } else{
    $query = "select * from user";
  }

  $result = mysqli_query($dbcon, $query);

  echo "<table border = '1'>";
  while($row = mysqli_fetch_array($result)){
    $count++;
    echo "<tr>";
    for ($i=1; $i < 5; $i++) { 
      echo "<td>".$row[$i]."</td>";
    }
  echo "</tr>";
  }
  echo "</table>";
  echo "$count 건의 검색결과가 있습니다.";
  
  //DB연결 종료
  mysqli_close($dbcon);
  
  ?>