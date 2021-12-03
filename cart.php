<html>
	<head></head>
	<body>
<?php
	error_reporting(E_ALL);
		//adding item to cart
	if (isset($_POST['PRODUCT_NAME'], $_POST['QUANTITY']) &&
		is_numeric($_POST['PRODUCT_NAME']) &&	//checks form data
		is_numeric($_POST['QUANITITY'])){
			$productName = (int)$_POST['PRODUCT_NAME'];	//set post variables
			$quantity = (int)$_POST['QUANTITY'];
			$results = $pdo->prepare('SELECT * FROM PRODUCTS WHERE PRODUCT_NAME = ?');
			$results = $pdo->execute([$_POST['PRODUCT_NAME']]); //checks if product exists
			$product = $results->fetch(PDO::FETCH_ASSOC); //fetches product & places into array

		if ($product && $quantity > 0) { //if array isn't empty
			if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])){ //create session variable for cart
				if(array_key_exists($productName, $_SESSION['cart'])){
					$_SESSION['cart'][$productName] += $quantity; //product exists, update quantity
				} else {
					$_SESSION['cart'][$productName] = $quantity; // product absent from cart so add
				}
			} else {
				$_SESSION['cart'] = array($productName => $quantity); //no products in cart & adds first product to cart
			}
		}
	}
		//removing item from cart
	if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['CART'][$_GET['remove']])){
		unset($_SESSION['cart'][$_GET['remove']]);
	}
		//updating product quantities
	if (isset($_POST['update']) && isset($_SESSION['cart'])){
		foreach ($_POST as $k => $v){
			if (strpos($k, 'quantity') !== false && is_numeric($v)){
				$id = str_replace('quantity-', '', $k);
				$quantity = (int)$v
					if(is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0){
						$_SESSION['cart'][$id] = $quantity;
					}
			}
		}
	}
		//order placed
	if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
		echo '<br><form action="checkoutpage.php">';
		echo '<input type="submit" value="Checkout"/>';
		echo '</form>'
	}

		//move products into cart from database
	$productsInCart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
	$products = array();
	$subtotal = 0.00;
	if($productsInCart{
		$questionMarkArray = implode(',', array_fill(0, count($productsInCart), '?'));
		$statement = $pdo->prepare('SELECT * FROM PRODUCTS WHERE PRODUCT_NAME IN ' . $questionMarkArray . ')');
		$statement = $pdo->execute(array_keys($productsInCart));
		$products = $statement->fetchAll(PDO::FETCH_ASSOC);

		foreach($products as $product){
			$subtotal += (float)$product['COST'] * (int)$productsInCart[$product['PRODUCT_NAME'
	}
?>

	<h1>Shopping Cart</h1>
	<div class="cart">
	<form action="index.php?page=cart" method="post">
		<table>
			<thead>
				<tr>
					<td colspan="2">Product</td>
					<td>Price</td>
					<td>Quantity</td>
					<td>Total</td>
				</tr>
			</thead>
		<tbody>
			<?php if(empty($products)): ?>
			<tr>
				<td colspan="5" style="text-align:center;">No products currently in Shopping Cart</td>
			</tr>
			<?php else: ?>
			<?php foreach($products as $product): ?>
			<tr>
				<td>
				<a href="index.php?page=product&id=<?=$product['PRODUCT_NAME']?>"><?=$product['PRODUCT_NAME']?></a>
				<br>
				<a href="index.php?page=cart&remove=<?=$product['PRODUCT_NAME']?>" class="remove">Remove</a></td>
				<td class="COST">&dollar;<?=$product['COST']?></td>
				<td class="QUANTITY">
				<input type="number" name="QUANTITY-<?=$product['PRODUCT_NAME']?>" value="<?=$productsInCart[$product['PRODUCT_NAME']]?>" min="1" max=<?product['QUANTITY']?> placeholder="Quantity" required>
				<td class="COST"&dollar;<?=$product['COST'] * $productsInCart[$product['PRODUCT_NAME']]?></td>
			</tr>
		</tbody>
		</table>
		<div class="subtotal">
			<span class="text">Subtotal</span>
			<span class="price">&dollar;<?=$subtotal?><span>
		</div>
		<div class="buttons">
			<input type="submit" value="Update" name="update">
			<input type="submit" value="Place Order" name="placeorder">
		</div>
	</form>
	</body>
</html>
