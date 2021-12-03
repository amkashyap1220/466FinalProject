<!DOCTYPE html>
<html>

<head>
    <title>Checkout</title>
</head>

<body>
    <?php
    /*
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

        # Total price
        $rs = $pdo->query("SELECT COST FROM CART;");
        $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
        $total = 0;
        foreach ($rows as $item) {
            $total = $total + $item['COST'];
        }
        echo "<h2>Purchase Total = $" . $total . "</h2>";

        #checkout
        echo '<form method="post">';
        #CARD STUFF
        # Card#
        echo "<h3>Card Information</h3>";
        echo 'Card #:<input type="text" name="CARD_NUMBER"><br>';
        # Cardholder name
        echo 'Card Holder Name:<input type="text" name="CARDHOLDER"><br>';
        # cvv
        echo 'CVV:<input type="text" name="CVV"><br>';
        #billing zip
        echo 'Billing Zip:<input type="text" name="BILLING_ZIP"><br>';

        # ADDRESS STUFF
        echo "<h3>Address Information</h3>";
        #zip
        echo 'Zip:<input type="text" name="ZIP"><br>';
        #street address
        echo 'Street Address:<input type="text" name="STREET_ADDRESS"><br>';
        #city
        echo 'City:<input type="text" name="CITY"><br>';
        #state
        echo 'State:<input type="text" name="STATE"><br>';

        #checkout btn
        echo '<br><input type="submit" value="Checkout" /><br>';
        echo "</form>";

        #if we've recieved a post do this...
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            #creating the order
            $prepared = $pdo->prepare('INSERT INTO ORDERS (TOTAL, CARD_NUMBER, CARDHOLDER, CVV, BILLING_ZIP, ZIP, STREET_ADDRESS, CITY, STATE) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?);');
            if ($prepared->execute(array($total, $_POST["CARD_NUMBER"], $_POST["CARDHOLDER"], $_POST["CVV"], $_POST["BILLING_ZIP"], $_POST["ZIP"], $_POST["STREET_ADDRESS"], $_POST["CITY"], $_POST["STATE"]))) {
                # success
                echo "Purchase Successful!";

                # update the quantities
                $rs = $pdo->query("SELECT * FROM CART;");
                $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
                foreach ($rows as $item) {

                    $pdo->exec('UPDATE PRODUCTS SET QUANTITY = QUANTITY - ' . $item['QUANTITY'] . ' WHERE PRODUCT_NAME="' . $item['PRODUCT_NAME'] . '";');
                }

                #clear the cart after a successful purchase
                $pdo->exec('delete from CART');
                header("Location: ordersuccess.php");
                exit();
            } else {
                echo "ERROR: One or more areas was not filled correctly... Try again";
            }
        }

        #cancel and go back to cart
        echo '<br><form action="cartpage.php">';
        echo '<input type="submit" value="Return cart" />';
        echo '</form>';

        #go to home screen
        echo '<br><form action="index.php">';
        echo '<input type="submit" value="Return to start" />';
        echo '</form>';
    } catch (PDOexception $e) {
        echo "Connection to database failed: " . $e->getMessage();
    }


    ?>
</body>

</html>