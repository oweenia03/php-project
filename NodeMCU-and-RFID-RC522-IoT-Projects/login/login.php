<?php
	$host = "localhost";
	$user = "root";
	$pass = "0107";
	$db = "nodemcu_rfid_iot_projects";

	$conn = new mysqli($host, $user, $pass, $db);


	if ($conn->connect_error) {
		die("연결실패: " . $conn->connect_error);
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$username = $_POST["username"];
		$password = $_POST["password"];

		// SQL Injection 방지 - prepared statement 사용
		$stmt = $conn->prepare("SELECT id FROM users_table WHERE username = ? AND password = ?");
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows > 0) {
			// 세션 시작
			session_start();
			$_SESSION["username"] = $username;
			
			// 리디렉션
			header("Location: ../home.php");
			exit();  // 리디렉션 후 추가 코드 실행 방지
		} else {
			$error = "아이디 또는 비밀번호가 잘못되었습니다.";
		}
	}
?>


<!-- login.html -->

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<link href="../css/bootstrap.min.css" rel="stylesheet">
		<script src="../js/bootstrap.min.js"></script>
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
		
		img {
			display: block;
			margin-left: auto;
			margin-right: auto;
		}
		</style>
	<title>Login</title>
</head>
<body>
	
	<ul class="topnav">
			<li><a class="active" href="login.php">Login</a></li>
			<li><a>Stock Data</a></li>
			<li><a>Registration</a></li>
			<li><a>Read Tag ID</a></li>
			<li><a>Search Stock</a></li>
			<li><a>Motor Record</a></li>
		</ul>
		<h2>Login</h2>
		<h4>Please log in to access the managers' website.</h4><br>

	<form action="login.php" method="post">
		<label for="username">ID:</label>
		<input type="text" id="username" name="username"><br><br><br>
		<label for="password">Password:</label>
		<input type="password" id="password" name="password"><br><br><br>
		<input type="submit" value="Login">
	</form>
	<footer>
        	<p>&copy; <?php echo date("Y"); ?> Tag-On</p>
    </footer>
</body>
</html>
