<!DOCTYPE html>
<html>

<head>
    <title>Success</title>
</head>

<body>
    <h1>Order Successfully Placed!</h1>
    <p>You may track your order by going to the track order page found at the start.</p>
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

        # Showing the order #
        echo "Your order # is: ";
        $rs = $pdo->query("SELECT ORDER_NUMBER FROM `ORDER` ORDER BY ORDER_NUMBER DESC LIMIT 1;");
        $row = $rs->fetch(PDO::FETCH_ASSOC);
        echo $row['ORDER_NUMBER'];

        echo '<br><form action="index.php">';
        echo '<input type="submit" value="Return to start" />';
        echo '</form>';
    } catch (PDOexception $e) {
        echo "Connection to database failed: " . $e->getMessage();
    }


    ?>
</body>

</html>