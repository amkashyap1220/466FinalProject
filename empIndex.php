<!DOCTYPE html>

<head>
    <title>ATG EMPLOYEE VIEW</title>
</head>

<body>
    <?php
    include("creds.php");
    include("library.php");
    try {
        # connect to DB
        $dsn = "mysql:host=courses;dbname=z1911560";
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
    } catch (PDOexception $e) {
        echo "Connection to database failed: " . $e->getMessage();
    }


    ?>
</body>

</html>