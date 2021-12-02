<!DOCTYPE html>
<html>

<head>
    <title>Cart</title>
</head>

<body>
    <?php
    # ALEXANDER KASHYAP DEC 2 2021
    include("creds.php");
    include("library.php");
    try {
        # connect to DB
        $dsn = "mysql:host=courses;dbname=z1926618";
        $pdo = new PDO($dsn, $username, $password);

        # Showing the cart
        echo "Shopping Cart...";
        $rs = $pdo->query("SELECT * FROM CART;");
        $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
        draw_table($rows);

        # TODO Total price
        $rs = $pdo->query("SELECT COST FROM CART;");
        $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
        $total = 0;
        foreach ($rows as $item) {
            $total = $total + $item['COST'];
        }
        echo "<br>Current Total = " . $total;

        #clear cart vutton
        echo '<form method="post">';
        echo '<br><input type="submit" value="Clear Cart" />';
        echo "</form>";

        #if we've recieved a post (clear cart button has been pressed) do this...
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            #clear the cart ...
            $pdo->exec('delete from CART');
        }

        #go to shopping cart screen
        echo '<br><form action="checkoutpage.php">';
        echo '<input type="submit" value="Checkout" />';
        echo '</form>';
    } catch (PDOexception $e) {
        echo "Connection to database failed: " . $e->getMessage();
    }


    ?>
</body>

</html>