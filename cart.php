<?php
	error_reporting(E_ALL);
	include("login.php");
	session_start();
	try {
		$dsn = "mysql:host=courses;dbname=z1839641";
		$pdo = new PDO($dsn, $username, $password);
		$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOexception $e){
		echo "Connection to database failed: " . $e->getMessage();
	}

	if (isset($_POST['PRODUCT_ID'], $_POST['QUANTITY']) &&
		is_numeric($_POST['PRODUCT_ID']) &&	//checks form data
		is_numeric($_POST['QUANITITY'])){
			$productid = (int)$_POST['PRODUCT_ID'];	//set post variables
			$quantity = (int)$_POST['QUANTITY'];
			$results = $pdo->prepare('SELECT * FROM PRODUCTS WHERE PRODUCT_ID = ?');
			$results = $pdo->execute([$_POST['PRODUCT_ID']]); //checks if product exists
			$product = $results->fetch(PDO::FETCH_ASSOC); //fetches product & places into array

		if ($product && $quantity > 0) { //if array isn't empty
			if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])){ //create session variable for cart
				if(array_key_exists($productid, $_SESSION['cart'])){
					$_SESSION['cart'][$productid] += $quantity; //product exists, update quantity
				} else {
					$_SESSION['cart'][$productid] = $quantity; // product absent from cart so add
				}
			} else {
				$_SESSION['cart'] = array($product_id => $quantity); //no products in cart & adds first product to cart
			}
		}
	}
?>
