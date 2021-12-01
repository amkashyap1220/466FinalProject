<!DOCTYPE html>
<html>
    <head>
        <title>ATG STORE</title>
    </head>
    <body>
    <?php
        include("creds.php");
        include("library.php");
        try {
            # connect to DB
            $dsn = "mysql:host=courses;dbname=z1926618";
            $pdo = new PDO($dsn, $username, $password);

            # 1
            $rs = $pdo->query("SELECT * FROM S;");
            $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
            draw_table($rows);

            #2
            $rs = $pdo->query("SELECT * FROM P;");
            $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
            draw_table($rows);

            ### the form for all other requirments ###
            # choosing a part
            echo '<form method="post">';
            echo '<label for="parts">Choose a part:</label>';
            echo '<select id="parts" name="parts">';
            $rs = $pdo->query("SELECT DISTINCT PNAME FROM P;");
            $row = $rs->fetchAll(PDO::FETCH_ASSOC);

            foreach ($row as $item) {
                foreach ($item as $it) {
                    echo "<option value=".$it.">".$it."</option>";
                }
            }

            #ch0osing a supplier
            echo "</select>";
            echo '<br><label for="parts">Choose a Supplier:</label>';
            echo '<select id="supplier" name="supplier">';
            $rs = $pdo->query("SELECT S FROM S;");
            $row = $rs->fetchAll(PDO::FETCH_ASSOC);
           
            foreach ($row as $item) {
                foreach ($item as $it) {
                    echo "<option value=".$it.">".$it."</option>";
                }
            }
            echo "</select>";

            # purchase form
            echo '<br><label for="parts">PURCHASE:Choose Part, Supplier, AMT:</label>';
            echo '<select id="p" name="p">';
            $rs = $pdo->query("SELECT P FROM P;");
            $row = $rs->fetchAll(PDO::FETCH_ASSOC);
         
            foreach ($row as $item) {
                foreach ($item as $it) {
                    echo "<option value=".$it.">".$it."</option>";
                }
            }
            echo "</select>";
            echo '<select id="s" name="s">';
            $rs = $pdo->query("SELECT S FROM S;");
            $row = $rs->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($row as $item) {
                foreach ($item as $it) {
                    echo "<option value=".$it.">".$it."</option>";
                }
            }
            echo "</select>";
            echo '<input type="text" name="q">';

            #input a new part
            echo '<br>Part to add info[P, PNAME, COLOR, WEIGHT]<input type="text" name="pp">';
            echo '<input type="text" name="pname">';
            echo '<input type="text" name="color">';
            echo '<input type="text" name="weight">';

            #input a new supplier
            echo '<br>Supplier to add info[S, SNAME, STATUS, CITY]<input type="text" name="ss">';
            echo '<input type="text" name="sname">';
            echo '<input type="text" name="status">';
            echo '<input type="text" name="city">';

            #submits
            echo '<br><input type="submit" value="Submit" />';
            echo "</form>";

            #inserting the new part/supplier
            $pdo->exec('INSERT INTO S (S, SNAME, CITY, STATUS) VALUES("'.$_POST["ss"].'", "'.$_POST['sname'].'", "'.$_POST['city'].'", '.$_POST["status"].");");
            $pdo->exec('INSERT INTO P (P, PNAME, COLOR, WEIGHT) VALUES("'.$_POST["pp"].'", "'.$_POST['pname'].'", "'.$_POST['color'].'", '.$_POST["weight"].");");

            #showing what the suppliers carry
            echo "Suppliers who carry ".$_POST["parts"]."s:<br>";
            $rs = $pdo->query('SELECT S, QTY, COLOR, WEIGHT FROM SP, P WHERE SP.P=P.P AND PNAME="'.$_POST["parts"].'";');
            $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                echo $row["S"]." has ".$row["QTY"]." ".$row["COLOR"]." ".$_POST["parts"]."s of weight ".$row["WEIGHT"]."<br>";
            }

            #showing info on the supplier chosen
            echo "<br>Info on Supplier: ".$_POST["supplier"]."<br>";
            $rs = $pdo->query('SELECT S.S, SNAME, STATUS, CITY, P, QTY FROM SP, S WHERE SP.S=S.S AND S.S="'.$_POST["supplier"].'";');
            $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
            draw_table($rows);

            #updating the qty
            $pdo->exec("UPDATE SP SET QTY = QTY - ".$_POST["q"].' WHERE P="'.$_POST["p"].'" AND S="'.$_POST["s"].'";');
            echo "<br> Updated Quantities: <br>";
            $rs = $pdo->query("SELECT * FROM SP;");
            $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
            draw_table($rows);



        
        }
        catch(PDOexception $e)
        {
            echo "Connection to database failed: ".$e->getMessage();
        }
        
        
    ?>   
    </body>
</html>