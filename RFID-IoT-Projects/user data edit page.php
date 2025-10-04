<?php
require 'database.php';

function fetchData($id) {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "SELECT * FROM table_the_iot_projects WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

$data = fetchData($id);
Database::disconnect();
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
            margin: 0 auto;
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

        ul.topnav li { float: left; }
        ul.topnav li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        ul.topnav li a:hover:not(.active) { background-color: #3e8e41; }
        ul.topnav li a.active { background-color: #333; }
        ul.topnav li.right { float: right; }

        @media screen and (max-width: 600px) {
            ul.topnav li.right, ul.topnav li { float: none; }
        }
    </style>
    
    <title>Edit: Stock Data</title>
</head>

<body>
    <h2 align="center">Tag-On Homepage for Managers</h2>

    <div class="container">
        <div class="center" style="margin: 0 auto; width:495px; border: solid #f2f2f2;">
            <div class="row">
                <h3 align="center">Edit Stock Data</h3>
            </div>

            <form class="form-horizontal" action="user data edit tb.php?id=<?php echo htmlspecialchars($id); ?>" method="post">
                <div class="control-group">
                    <label class="control-label">ID</label>
                    <div class="controls">
                        <input name="id" type="text" value="<?php echo htmlspecialchars($data['id']); ?>" readonly>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Name</label>
                    <div class="controls">
                        <input name="uname" type="text" value="<?php echo htmlspecialchars($data['uname']); ?>" required>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Price</label>
                    <div class="controls">
                        <input name="price" type="text" value="<?php echo htmlspecialchars($data['price']); ?>" required>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Expiration Date</label>
                    <div class="controls">
                        <input name="Expiration" type="date" value="<?php echo htmlspecialchars($data['Expiration']); ?>" required>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Stock Status</label>
                    <div class="controls">
                        <select name="stock_status" required>
                            <option value="N" <?php echo ($data['stock_status'] == 'N') ? 'selected' : ''; ?>>N</option>
                            <option value="Y" <?php echo ($data['stock_status'] == 'Y') ? 'selected' : ''; ?>>Y</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a class="btn" href="user data.php">Back</a>
                </div>
            </form>
        </div>               
    </div> <!-- /container -->    
</body>
</html>
