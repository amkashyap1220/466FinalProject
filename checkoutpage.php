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
    ?>

        <form method="post">
            <h3>Card Information</h3>
            Card #:<input type="text" name="CARD_NUMBER"><br>
            Card Holder Name:<input type="text" name="CARDHOLDER"><br>
            CVV:<input type="text" name="CVV"><br>
            Billing Zip:<input type="text" name="BILLING_ZIP"><br>

            <h3>Address Information</h3>
            Zip:<input type="text" name="ZIP"><br>
            Street Address:<input type="text" name="STREET_ADDRESS"><br>
            City:<input type="text" name="CITY"><br>
            State:<input type="text" name="STATE"><br>

            <br><input type="submit" value="Checkout" /><br>
        </form>
        <?php
        #if we've recieved a post do this...
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            #creating the order
            $prepared = $pdo->prepare('INSERT INTO `ORDER` (TOTAL, CARD_NUMBER, CARDHOLDER, CVV, BILLING_ZIP, ZIP, STREET_ADDRESS, CITY, STATE) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?);');
            if ($prepared->execute(array($total, $_POST["CARD_NUMBER"], $_POST["CARDHOLDER"], $_POST["CVV"], $_POST["BILLING_ZIP"], $_POST["ZIP"], $_POST["STREET_ADDRESS"], $_POST["CITY"], $_POST["STATE"]))) {
                # success
                echo "Purchase Successful!";

                # update the quantities
                $rs = $pdo->query("SELECT * FROM CART;");
                $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
                foreach ($rows as $item) {

                    $pdo->exec('UPDATE PRODUCT SET QUANTITY = QUANTITY - ' . $item['QUANTITY'] . ' WHERE PRODUCT_NAME="' . $item['PRODUCT_NAME'] . '";');
                }

                #before clearing the cart we have to add the things to the items_ordered table, so emp can look up what items were with that accociated order
                $rs = $pdo->query("SELECT ORDER_NUMBER FROM `ORDER` ORDER BY ORDER_NUMBER DESC LIMIT 1;");
                $row = $rs->fetch(PDO::FETCH_ASSOC);
                $onum =  $row['ORDER_NUMBER']; # getting the order number for this order
                # loop through each item in the cart and insert into the items_ordered
                $rs = $pdo->query("SELECT PRODUCT_NAME, QUANTITY FROM CART;");
                $row = $rs->fetchAll(PDO::FETCH_ASSOC);
                $prepared = $pdo->prepare('INSERT INTO ITEM_ORDER (ORDER_NUMBER, PRODUCT_NAME, QUANTITY) VALUES(?, ?, ?);');
                foreach ($row as $item) {
                    $prepared->execute(array($onum, $item['PRODUCT_NAME'], $item['QUANTITY']));
                }

                #clear the cart after a successful purchase
                $pdo->exec('delete from CART');
                header("Location: ordersuccess.php");
                exit();
            } else {
                echo "ERROR: One or more areas was not filled correctly... Try again";
            }
        }
        ?>

        <br>
        <form action="cartpage.php">
            <input type="submit" value="Return cart" />
        </form>
        <br>
        <form action="index.php">
            <input type="submit" value="Return to start" />
        </form>
    <?php
    } catch (PDOexception $e) {
        echo "Connection to database failed: " . $e->getMessage();
    }


    ?>
</body>

</html>