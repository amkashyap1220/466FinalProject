<!DOCTYPE html>
<html>

<head>
    <title>ATG STORE</title>
</head>

<body>
    <?php
    /*
        Alexander Kashyap Z1926618
        DEC 1 2021
        Group Project
    */
    include("creds.php");
    include("library.php");
    try {
        # connect to DB
        $dsn = "mysql:host=courses;dbname=z1926618";
        $pdo = new PDO($dsn, $username, $password);

        # Showing all of the products
        echo "ATG, Product list...";
        $rs = $pdo->query("SELECT * FROM PRODUCT;");
        $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
        draw_table($rows);
    ?>

        <form method="post">
            <br><label for="parts">Select Part:</label>
            <select id="parts" name="parts">
                <?php
                $rs = $pdo->query("SELECT PRODUCT_NAME, PRICE FROM PRODUCT;");
                $row = $rs->fetchAll(PDO::FETCH_ASSOC);
                echo '<option value="">Select Part</option>';
                foreach ($row as $item) {
                    #the options to select from in the drop down
                    echo '<option value="' . $item["PRODUCT_NAME"] . "|" . $item["PRICE"] . '">' . $item["PRODUCT_NAME"] . "</option>";
                }
                ?>
            </select><br>


            <label for="quantity">Enter Quantity:</label>
            <input type="text" id="quantity" name="quantity"><br>


            <br><input type="submit" value="Add to Cart" />
        </form>
        <?php
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
                $pdo->exec('UPDATE CART SET QUANTITY = ' . $_POST['quantity'] . ' WHERE PRODUCT_NAME="' . $result_explode[0] . '";');
                $newcost = $result_explode[1] * $_POST["quantity"];
                $pdo->exec('UPDATE CART SET COST = ' . $newcost . ' WHERE PRODUCT_NAME="' . $result_explode[0] . '";');
                echo "You already had this item in your cart so I updated the quantity for you...";
            }
        }
        ?>
        <br>
        <form action="cartpage.php">
            <input type="submit" value="Go to Cart" />
        </form>


        <br>
        <form action="ordertracking.php">
            <input type="submit" value="Track your order here" />
        </form>


        <br><br><br><br>
        <form action="empIndex.php">
            <input type="submit" value="Edit/Employee View" />
        </form>
    <?php
    } catch (PDOexception $e) {
        echo "Connection to database failed: " . $e->getMessage();
    }


    ?>
</body>

</html>