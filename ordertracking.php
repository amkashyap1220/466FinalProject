<!DOCTYPE html>
<html>

<head>
    <title>Success</title>
</head>

<body>
    <h1>Order Tracking</h1>
    <p>Enter your order number to check order info and its current status.</p>
    <?php
    /*
        Alexander Kashyap Z1926618
        DEC 2 2021
        Group Project
    */

    #including loging credentials and library
    include("creds.php");
    include("library.php");

    try {
        # connect to DB
        $dsn = "mysql:host=courses;dbname=z1926618";
        $pdo = new PDO($dsn, $username, $password);

        #order number
        echo '<form method="post">';
        echo 'Order Number:<input type="text" name="ordernum"><br>';

        #submit
        echo '<br><input type="submit" value="Track" /><br>';
        echo "</form>";

        # display the tracking info.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rs = $pdo->query("SELECT STATUS, TOTAL FROM `ORDER` where ORDER_NUMBER=" . $_POST['ordernum'] . ';');
            $row = $rs->fetch(PDO::FETCH_ASSOC);
            echo "Current Status: ";
            echo $row['STATUS'];
            echo '<br>Order Total: ';
            echo $row['TOTAL'];
        }
    } catch (PDOexception $e) {
        echo "Connection to database failed: " . $e->getMessage();
    }


    ?>
</body>

</html>