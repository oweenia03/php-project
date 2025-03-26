<?php

// 데이터베이스 연결 파일 포함
include 'database.php';
$new_dbcon = Database::connect('table_the_iot_projects'); // 기존 테이블에 연결

// UID 가져오기
$UIDresult = '';
if (file_exists('motor_UIDContainer.php')) {
    include 'motor_UIDContainer.php'; // UIDContainer.php에서 UID 가져옴
}

// 날짜 필터링을 위한 변수 초기화
$searchDate = isset($_POST['searchDate']) ? $_POST['searchDate'] : '';

// 날짜에 따라 작동 기록 필터링
$motorResults = '';
$motorQuery = "SELECT * FROM motor_table";
if ($searchDate) {
    $motorQuery .= " WHERE DATE(recognized_time) = :searchDate"; // 날짜 필터 추가
}

$motorStmt = $new_dbcon->prepare($motorQuery);
if ($searchDate) {
    $motorStmt->bindParam(':searchDate', $searchDate);
}
try {
    $motorStmt->execute();
    $motorCount = $motorStmt->rowCount();
    if ($motorCount > 0) {
        $motorResults .= "<br><h2>보안 장치 작동 기록<br></h2>

        <form method='POST' action=''>
            <label for='searchDate'>날짜 검색 (YYYY-MM-DD): </label>
            <input type='date' id='searchDate' name='searchDate' value='" . htmlspecialchars($searchDate) . "'>
            <input type='submit' value='검색'>
        </form>
    
        <table border='1' class='results-table'>
            <tr>
                <th>ID</th>
                <th>품명</th>
                <th>가격</th>
                <th>유통기한</th>
                <th>계산 여부</th>
                <th>인식 시간</th> <!-- 인식 시간 추가 -->
            </tr>";
        while ($motorRow = $motorStmt->fetch(PDO::FETCH_ASSOC)) {
            $motorResults .= "<tr>";
            $motorResults .= "<td>" . htmlspecialchars($motorRow['id']) . "</td>";  
            $motorResults .= "<td>" . htmlspecialchars($motorRow['uname']) . "</td>";
            $motorResults .= "<td>" . htmlspecialchars($motorRow['price']) . "</td>";
            $motorResults .= "<td>" . htmlspecialchars($motorRow['Expiration']) . "</td>";
            $motorResults .= "<td>" . htmlspecialchars($motorRow['stock_status']) . "</td>";
            $motorResults .= "<td>" . htmlspecialchars($motorRow['recognized_time']) . "</td>"; // 인식 시간 출력
            $motorResults .= "</tr>";
        }
        $motorResults .= "</table>";
        $motorResults .= "<br>$motorCount 건의 Motor Table 데이터가 있습니다.";
    } else {
        $motorResults = "Motor Table에 데이터가 없습니다.";
    }
} catch (PDOException $e) {
    echo "SQL Error: " . $e->getMessage();
    exit; // 스크립트 종료
}

// UID가 있는 경우 해당 UID에 대한 데이터를 검색
if (!empty($UIDresult)) {
    $query = "SELECT * FROM table_the_iot_projects WHERE id = :uid AND stock_status = 'N'";
    $stmt = $new_dbcon->prepare($query);
    $stmt->bindParam(':uid', $UIDresult);
    try {
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // motor_table에서 동일한 UID가 있는지 확인
            $checkQuery = "SELECT * FROM motor_table WHERE id = :id ORDER BY recognized_time DESC LIMIT 1"; // 최신 데이터 확인
            $checkStmt = $new_dbcon->prepare($checkQuery);
            $checkStmt->bindParam(':id', $row['id']);
            $checkStmt->execute();
            $latestMotorData = $checkStmt->fetch(PDO::FETCH_ASSOC);

            // 동일한 UID의 데이터가 존재하는 경우 recognized_time 비교
            if (!$latestMotorData || (strtotime('now') - strtotime($latestMotorData['recognized_time']) > 300)) { // 5분(300초) 이상 차이
                $insertQuery = "INSERT INTO motor_table (id, uname, price, Expiration, stock_status, recognized_time)
                                VALUES (:id, :uname, :price, :expiration, :stock_status, NOW())"; // recognized_time에 현재 시간 저장
                $insertStmt = $new_dbcon->prepare($insertQuery);
                $insertStmt->bindParam(':id', $row['id']);
                $insertStmt->bindParam(':uname', $row['uname']);
                $insertStmt->bindParam(':price', $row['price']);
                $insertStmt->bindParam(':expiration', $row['Expiration']);
                $insertStmt->bindParam(':stock_status', $row['stock_status']);

                $insertStmt->execute();
            }
        }
    } catch (PDOException $e) {
        echo "SQL Error: " . $e->getMessage();
        exit; // 스크립트 종료
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
    
    <title>Motor Record</title>
   
</head>

<body>
    <h2>Tag-On Homepage for Managers</h2>
    <ul class="topnav">
        <li><a href="home.php">Home</a></li>
        <li><a href="user data.php">Stock Data</a></li>
        <li><a href="registration.php">Registration</a></li>
        <li><a href="read tag.php">Read Tag ID</a></li>
        <li><a href="search.php">Search Stock</a></li>
        <li><a class="active" href="motor.php">Motor Record</a></li>
        <li class="right"><a href="login/logout.php">Logout</a></li>  <!-- 로그아웃 버튼 추가 -->
    </ul>

    <div id="motorResults"><?php echo $motorResults; ?></div>

    <!-- Footer -->
    <footer>
        <br><p>&copy; <?php echo date("Y"); ?> Tag-On</p>
    </footer>
</body>
</html>
