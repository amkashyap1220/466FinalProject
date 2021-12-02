<!DOCTYPE html>
<html>

<head>
    <title>ATG STORE</title>
</head>

<body>
    <?php
    # ALEXANDER KASHYAP DEC 1 2021
    include("creds.php");
    include("library.php");
    try {
        # connect to DB
        $dsn = "mysql:host=courses;dbname=z1926618";
        $pdo = new PDO($dsn, $username, $password);

        # Showing all of the products
        echo "ATG, Product list...";
        $rs = $pdo->query("SELECT * FROM PRODUCTS;");
        $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
        draw_table($rows);

        ### the form ###
        # choosing a part
        echo '<form method="post">';
        echo '<br><label for="parts">Select Part:</label>';
        echo '<select id="parts" name="parts">';
        $rs = $pdo->query("SELECT PRODUCT_NAME, PRICE FROM PRODUCTS;");
        $row = $rs->fetchAll(PDO::FETCH_ASSOC);

        foreach ($row as $item) {
            #the options to select from in the drop down
            echo '<option value="' . $item["PRODUCT_NAME"] . "|" . $item["PRICE"] . '">' . $item["PRODUCT_NAME"] . "</option>";
        }
        echo '</select><br>';

        #select the quantity for that part (text entry)
        echo '<label for="quantity">Select Quantity:</label>';
        echo '<input type="text" id="quantity" name="quantity"><br>';

        #add to cart button
        echo '<br><input type="submit" value="Add to Cart" />';
        echo "</form>";

        #if we've recieved a post (add to cart button has been pressed) do this...
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            #inserting the items chosen into shopping cart
            $prepared = $pdo->prepare('INSERT INTO CART (PRODUCT_NAME, QUANTITY, COST) VALUES(?, ?, ?);');
            $result = $_POST['parts']; #break apart the price and the product name with explode
            $result_explode = explode('|', $result);
            #adding the item to the cart
            if ($prepared->execute(array($result_explode[0], $_POST["quantity"], $result_explode[1] * $_POST["quantity"]))) {
                # item is not already in the cart
                echo "Item added successfully!";
            } else {
                # this item is already in the cart!
                echo "ERROR: This item is already in your cart! Remove items from cart and add with the updated quantity please.";
            }
        }

        #go to shopping cart screen
        echo '<br><form action="cartpage.php">';
        echo '<input type="submit" value="Go to Cart" />';
        echo '</form>';

        #go to employee screen
        echo '<br><br><br><br><form action="empIndex.php">';
        echo '<input type="submit" value="Edit/Employee View" />';
        echo '</form>';
    } catch (PDOexception $e) {
        echo "Connection to database failed: " . $e->getMessage();
    }


    ?>
</body>

</html>