<?php
// 오류 표시
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 데이터베이스 연결 파일 포함
include 'database.php';
$dbcon = Database::connect(); // PDO 연결

// 사용자 입력 초기화
$uname = isset($_POST['uname']) ? $_POST['uname'] : '';
$expiration_date = isset($_POST['reg_date']) ? $_POST['reg_date'] : '';

// 검색 결과 초기화
$searchResults = '';
$count = 0;

// DB 질의문 작성
if ($uname || $expiration_date) {
    $query = "SELECT * FROM table_the_iot_projects WHERE 1=1"; // 기본 쿼리
    if ($uname) {
        $query .= " AND uname LIKE :uname";
    }
    if ($expiration_date) {
        $query .= " AND Expiration <= :expiration_date";
    }

    // DB 질의문 준비
    $stmt = $dbcon->prepare($query);

    // 파라미터 바인딩
    if ($uname) {
        $stmt->bindValue(':uname', '%' . $uname . '%', PDO::PARAM_STR);
    }
    if ($expiration_date) {
        $stmt->bindValue(':expiration_date', $expiration_date, PDO::PARAM_STR);
    }

    // DB 질의문 실행
    $stmt->execute();

    // 결과 출력
    $count = $stmt->rowCount();
    if ($count > 0) {
       
        $searchResults .= "<table border='1' class='results-table'>
            <tr>
                <th>ID</th>
                <th>품명</th>
                <th>가격</th>
                <th>유통기한</th>
                <th>계산 여부</th>
            </tr>";
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $searchResults .= "<tr>";
            $searchResults .= "<td>" . htmlspecialchars($row['id']) . "</td>";  
            $searchResults .= "<td>" . htmlspecialchars($row['uname']) . "</td>";
            $searchResults .= "<td>" . htmlspecialchars($row['price']) . "</td>";
            $searchResults .= "<td>" . htmlspecialchars($row['Expiration']) . "</td>";
            $searchResults .= "<td>" . htmlspecialchars($row['stock_status']) . "</td>";  
            $searchResults .= "</tr>";
        }
        $searchResults .= "</table>";
        $searchResults .= "$count 건의 검색결과가 있습니다.";
    } else {
        $searchResults = "검색 결과가 없습니다.";
    }
}

// DB 연결 종료
Database::disconnect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <style>
        html {
            font-family: Arial;
            display: inline-block;
            margin: 0px auto;
            text-align: center;
        }

        ul.topnav {
            list-style-type: none;
            margin: auto;
            padding: 0;
            overflow: hidden;
            background-color: #4CAF50;
            width: 70%;
        }

        ul.topnav li {float: left;}

        ul.topnav li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        ul.topnav li a:hover:not(.active) {background-color: #3e8e41;}

        ul.topnav li a.active {background-color: #333;}

        ul.topnav li.right {float: right;}

        @media screen and (max-width: 600px) {
            ul.topnav li.right, 
            ul.topnav li {float: none;}
        }

        /* 테이블 중앙 정렬 */
        .results-table {
            margin: 20px auto;
            width: 40%;
            border-collapse: collapse;
        }

        .results-table th, .results-table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        thead {
            color: #FFFFFF;
            background-color: #4CAF50; /* 테이블 헤더 배경색 */
        }

        /* 검색 결과 메시지 스타일 */
        #searchResults {
            margin-top: 20px;
        }
    </style>
    
    <title>Search : Stock data</title>
</head>

<body>
    <h2>Tag-On Homepage for Managers</h2>
    <ul class="topnav">
        <li><a href="home.php">Home</a></li>
        <li><a href="user data.php">Stock Data</a></li>
        <li><a href="registration.php">Registration</a></li>
        <li><a href="read tag.php">Read Tag ID</a></li>
        <li><a class="active" href="search.php">Search Stock</a></li>
        <li><a href="motor.php">Motor Record</a></li>
        <li class="right"><a href="login/logout.php">Logout</a></li>  <!-- 로그아웃 버튼 추가 -->
    </ul>
    <br>
    
    <h1>재고 검색하기</h1>
    <fieldset>
        <form id="searchForm" method="post">
            <label for="uname">품명: </label><input type="text" name="uname" id="uname" /><br />
            <label for="reg_date">유통 기한 : </label><input type="date" name="reg_date" id="reg_date" /><br />
            <input type="submit" value="검색" />
        </form>
    </fieldset> <br><br>

    <div id="searchResults">
        <!-- 검색 결과가 여기에 표시됩니다 -->
        <?php echo $searchResults; ?>
    </div>
    <footer>
        	<p>&copy; <?php echo date("Y"); ?> Tag-On</p>
    	</footer>
</body>
</html>
