<?php
    // UIDContainer.php에 빈 UID값 초기화
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
    <script src="jquery.min.js"></script>

    <script>
        $(document).ready(function(){
            // UIDContainer.php에서 UID값을 불러와 id 입력란에 삽입
            setInterval(function() {
                $("#getUID").load("UIDContainer.php", function(response) {
                    // UID 값을 id 필드에 자동으로 넣기
                    $("#id").val(response.trim());
                });
            }, 500);
        });
    </script>

    <style>
        html {
            font-family: Arial;
            display: inline-block;
            margin: 0px auto;
        }

        textarea {
            resize: none;
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
    </style>

    <title>Registration : Stock data</title>
</head>

<body>

    <h2 align="center">Tag-On Homepage for Managers</h2>
    <ul class="topnav">
        <li><a href="home.php">Home</a></li>
        <li><a href="user data.php">Stock Data</a></li>
        <li><a class="active" href="registration.php">Registration</a></li>
        <li><a href="read tag.php">Read Tag ID</a></li>
        <li><a href="search.php">Search Stock</a></li>
        <li><a href="motor.php">Motor Record</a></li>
        <li class="right"><a href="login/logout.php">Logout</a></li>  <!-- 로그아웃 버튼 추가 -->
    </ul>

    <div class="container">
        <br>
        <div class="center" style="margin: 0 auto; width:495px; border-style: solid; border-color: #f2f2f2;">
            <div class="row">
                <h3 align="center">Registration Form</h3>
            </div>
            <br>
            <!-- Registration Form -->
            <form class="form-horizontal" action="insertDB.php" method="post">
                <div class="control-group">
                    <label class="control-label">ID</label>
                    <div class="controls">
                        <!-- UID 값을 자동으로 여기에 넣음 -->
                        <input id="id" name="id" type="text" placeholder="Enter ID" required>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">Product Name</label>
                    <div class="controls">
                        <input name="uname" type="text" placeholder="Enter product name" required>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">Price</label>
                    <div class="controls">
                        <input name="price" type="number" placeholder="Enter price" required>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">Expiration Date</label>
                    <div class="controls">
                        <input name="expiration" type="date" placeholder="Enter expiration date" required>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">Stock Status</label>
                    <div class="controls">
                        <select name="stock_status" required>
                            <option value="N">N</option>
                            <option value="Y">Y</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>               
    </div> <!-- /container -->  

    <!-- UID 값을 불러오는 숨겨진 div -->
    <div id="getUID" style="visibility:hidden;"></div>
    
</body>
</html>
