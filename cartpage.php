<!DOCTYPE html>
<html>

<head>
    <title>Cart</title>
</head>

<body>
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

        # Showing the cart
        echo "<h1>Shopping Cart</h1>";
        $rs = $pdo->query("SELECT * FROM CART;");
        $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
        draw_table($rows);

        # Total price
        $rs = $pdo->query("SELECT COST FROM CART;");
        $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
        $total = 0;
        foreach ($rows as $item) { # sum the cost of all things in the cart
            $total = $total + $item['COST'];
        }
        echo "<br><h3>Current Total = $" . $total . "</h3>";

        ### Update quanity of select item from a drop down
        echo '<br><br>Update Quantity:';
        echo '<form method="post">';
        echo '<label for="parts">Item from cart:</label>';
        echo '<select id="parts" name="parts">';
        $rs = $pdo->query("SELECT PRODUCT_NAME FROM CART;");
        $row = $rs->fetchAll(PDO::FETCH_ASSOC);
        echo '<option value="">Select Part</option>';
        foreach ($row as $item) {
            #the options to select from in the drop down
            echo '<option value="' . $item["PRODUCT_NAME"] . '">' . $item["PRODUCT_NAME"] . "</option>";
        }
        echo '</select>';

        #input the new quantity for that part you want to change
        echo '<label for="quantity">New Quantity:</label>';
        echo '<input type="text" id="quantity" name="quantity">';

        # hit the update button to update...
        echo '<input type="submit" value="Update" />';
        echo "</form>";

        ### clear aselect item
        echo '<br>Remove Item:';
        echo '<form method="post">';
        echo '<label for="rpart">Item from cart:</label>';
        echo '<select id="rpart" name="rpart">';
        $rs = $pdo->query("SELECT PRODUCT_NAME FROM CART;");
        $row = $rs->fetchAll(PDO::FETCH_ASSOC);
        echo '<option value="">Select Part</option>';
        foreach ($row as $item) {
            #the options to select from in the drop down
            echo '<option value="' . $item["PRODUCT_NAME"] . '">' . $item["PRODUCT_NAME"] . "</option>";
        }
        echo '</select>';
        echo '<input type="submit" value="Remove" />';
        echo "</form>";

        #clear entire cart vutton
        echo '<form method="post">';
        echo '<br><input type="submit" name="clear" value="Clear Entire Cart" />';
        echo "</form>";

        #if we've recieved a post (clear cart button has been pressed) do this...
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            #clear the cart ...
            if (isset($_POST['clear'])) {
                $pdo->exec('delete from CART');
                #refresh page
                echo "<meta http-equiv='refresh' content='0'>";
            }
            if (isset($_POST['parts'])) {
                $pdo->exec('UPDATE CART SET QUANTITY = ' . $_POST['quantity'] . ' WHERE PRODUCT_NAME="' . $_POST['parts'] . '";');
                $rs = $pdo->query('select PRICE from PRODUCT where PRODUCT_NAME="' . $_POST['parts'] . '";');
                $row = $rs->fetch(PDO::FETCH_ASSOC);
                $newcost = $row['PRICE'] * $_POST['quantity'];
                $pdo->exec('UPDATE CART SET COST = ' . $newcost . ' WHERE PRODUCT_NAME="' . $_POST['parts'] . '";');

                #refresh page
                echo "<meta http-equiv='refresh' content='0'>";
            }
            if (isset($_POST['rpart'])) {
                $pdo->exec('delete from CART where PRODUCT_NAME="' . $_POST['rpart'] . '";');
                #refresh
                echo "<meta http-equiv='refresh' content='0'>";
            }
        }

        #go to shopping cart screen
        echo '<br><form action="checkoutpage.php">';
        echo '<input type="submit" value="Checkout" />';
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