<?php
$Write="<?php $" . "UIDresult=''; " . "echo $" . "UIDresult;" . " ?>";
file_put_contents('UIDContainer.php', $Write);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
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

        .table {
            margin: auto;
            width: 90%; 
        }
        
        thead {
            color: #FFFFFF;
        }
    </style>
    
    <title>Stock Data</title>
</head>

<body>
    <h2>Tag-On Homepage for Managers</h2>
    <ul class="topnav">
        <li><a href="home.php">Home</a></li>
        <li><a class="active" href="user data.php">Stock Data</a></li>
        <li><a href="registration.php">Registration</a></li>
        <li><a href="read tag.php">Read Tag ID</a></li>
        <li><a href="search.php">Search Stock</a></li>
        <li><a href="motor.php">Motor Record</a></li>
        <li class="right"><a href="login/logout.php">Logout</a></li>  <!-- 로그아웃 버튼 추가 -->
    </ul>
    <br>
    <div class="container">
        <div class="row">
            <h3>Stock Data Table</h3>
        </div>
        <div class="row">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr bgcolor="#10a0c5" style="color: #FFFFFF;">
                        <th>ID</th> <!-- ID 열 추가 -->
                        <th>Name</th>
                        <th>Price</th>
                        <th>Expiration</th>
                        <th>Stock Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    include 'database.php';
                    $pdo = Database::connect();
                    // id 필드를 포함하여 데이터를 조회합니다.
                    $sql = 'SELECT id, uname, price, Expiration, stock_status FROM table_the_iot_projects ORDER BY uname ASC';
                    foreach ($pdo->query($sql) as $row) {
                        echo '<tr>';
                        echo '<td>'. $row['id'] . '</td>'; // ID 출력
                        echo '<td>'. $row['uname'] . '</td>'; // Name 출력
                        echo '<td>'. $row['price'] . '</td>'; // Price 출력
                        echo '<td>'. $row['Expiration'] . '</td>'; // Expiration 출력
                        echo '<td>'. $row['stock_status'] . '</td>'; // Stock Status 출력
                        echo '<td><a class="btn btn-success" href="user data edit page.php?id='.$row['id'].'">Edit</a>';
                        echo ' ';
                        echo '<a class="btn btn-danger" href="user data delete page.php?id='.$row['id'].'">Delete</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    Database::disconnect();
                ?>
                </tbody>
            </table>
        </div>
    </div> <!-- /container -->
    <footer>
        	<br><p>&copy; <?php echo date("Y"); ?> Tag-On</p>
    	</footer>
</body>
</html>
