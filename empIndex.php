<!DOCTYPE html>

<head>
    <title>ATG EMPLOYEE VIEW</title>
</head>

<body>
    <?php
    /*
        Greg Gancarz Z1911560
        Alexander Kashyap Z1926618
        DEC 2 2021
        Group Project
    */
    include("creds.php");
    include("library.php");
    try {
        # connect to DB
        $dsn = "mysql:host=courses;dbname=z1926618";
        $pdo = new PDO($dsn, $username, $password);

        # 1  - Lists all orders currently recieved into system.
        echo '<h3>RECIEVED ORDERS</h3>';
        $rs = $pdo->query("SELECT * FROM `ORDER`;");
        $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
        draw_table($rows);


        # 2  - Master inventory List

        echo '<h3>Master inventory list</h3>';
        $rs = $pdo->query('SELECT * FROM PRODUCT;');
        $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
        draw_table($rows);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['status'])) {
                $pdo->exec('UPDATE `ORDER` SET STATUS="' . $_POST['status'] . '" WHERE ORDER_NUMBER=' . $_POST['ordernum'] . ';');
                #refresh page
                echo "<meta http-equiv='refresh' content='0'>";
            }
            if (isset($_POST["note"])) {
                $pdo->exec('UPDATE `ORDER` SET NOTES="' . $_POST['note'] . '" WHERE ORDER_NUMBER=' . $_POST['ordernum2'] . ';');
                #refresh page
                echo "<meta http-equiv='refresh' content='0'>";
            }
        }
    } catch (PDOexception $e) {
        echo "Connection to database failed: " . $e->getMessage();
    }


    ?>

    <br>Update order status:<br>
    <form method="post">
        Order #:<input type="text" name="ordernum">
        <label for="status">New Status:</label>
        <select id="status" name="status">
            <option value="">Select Status</option>
            <option value="Processing">Processing</option>
            <option value="Processed">Processed</option>
            <option value="Shipped">Shipped</option>
            <option value="Delivered">Delivered</option>
        </select>
        <input type="submit" value="Update Status" />
    </form>

    <br>Add note to order:<br>
    <form method="post">
        Order #:
        <input type="text" name="ordernum2">
        <br>
        <textarea name="note" rows="12" cols="60">
        Enter Note Here. (500 char limit)
        </textarea>
        <input type="submit" value="Add Note">
    </form>

    <br>
    Order lookup<br>
    <form method="post">
        Order #:
        <input type="text" name="ordernum3">
        <input type="submit" value="Lookup">
    </form>
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST["ordernum3"]))
            {
                echo 'Items Ordered in Order #: '.$_POST['ordernum3'];
                $rs = $pdo->query("SELECT PRODUCT_NAME, QUANTITY FROM ITEM_ORDER WHERE ORDER_NUMBER=".$_POST['ordernum3'].";");
                $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
                draw_table($rows);
            }
        }
    ?>
    <br>
    <form action="index.php">
        <input type="submit" value="Return to Customer View" />
    </form>
</body>

</html>