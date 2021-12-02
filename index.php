<!DOCTYPE html>
<html>
    <head>
        <title>ATG STORE</title>
    </head>
    <body>
    <?php

        #ALEXANDER KASHYAP DEC 1 2021
        
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
            $rs = $pdo->query("SELECT DISTINCT PRODUCT_NAME FROM PRODUCTS;");
            $row = $rs->fetchAll(PDO::FETCH_ASSOC);

            foreach ($row as $item) {   
                foreach ($item as $it) {
                    echo "<option value=".$it.">".$it."</option>";
                }
            }
            echo '</select><br>';

            #select the quantity for that part
            echo '<label for="quantity">Select Quantity:</label>';
            echo '<input type="text" id="quantity" name="quantity"><br>';

            #add to cart
            echo '<br><input type="submit" value="Add to Cart" />';
            echo "</form>";


            #go to shopping cart screen
            echo '<br><form action="https://google.com">';
            echo '<input type="submit" value="Checkout/Go to Cart" />';
            echo '</form>';

            #go to employee screen
            echo '<br><br><br><br><form action="https://google.com">';
            echo '<input type="submit" value="Edit/Employee View" />';
            echo '</form>';

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                #inserting the items chosen into shopping cart
                $prepared = $pdo->prepare('INSERT INTO CART (PRODUCT_NAME, QUANTITY, COST) VALUES(?, ?, ?);');
                $prepared->execute(array($_POST["parts"], $_POST["quantity"], 1.99));
            }



        
        }
        catch(PDOexception $e)
        {
            echo "Connection to database failed: ".$e->getMessage();
        }
        
        
    ?>   
    </body>
</html>