<?php
require 'database.php';
$id = 0;

if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if (!empty($_POST)) {
    // Keep track post values
    $id = $_POST['id'];

    // Delete data
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
        $sql = "DELETE FROM table_the_iot_projects WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));

        // Check if any row was deleted
        if ($q->rowCount() > 0) {
            // Successful deletion
            header("Location: user data.php");
            exit;
        } else {
            // No rows affected (perhaps the ID does not exist)
            echo "<p class='alert alert-warning'>No data found with that ID.</p>";
        }
    } catch (PDOException $e) {
        echo "<p class='alert alert-danger'>Error: " . $e->getMessage() . "</p>";
    }

    Database::disconnect();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <title>Delete: Stock data</title>
</head>

<body>
    <h2 align="center">Tag-On Homepage for Managers</h2>

    <div class="container">
        <div class="span10 offset1">
            <div class="row">
                <h3 align="center">Delete Stock</h3>
            </div>

            <form class="form-horizontal" action="user data delete page.php" method="post">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>"/>
                <p class="alert alert-error">Are you sure to delete?</p>
                <div class="form-actions">
                    <button type="submit" class="btn btn-danger">Yes</button>
                    <a class="btn" href="user data.php">No</a>
                </div>
            </form>
        </div>
    </div> <!-- /container -->
</body>
</html>
