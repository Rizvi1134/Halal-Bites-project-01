<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu - Halal Bites</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="menu-container">

<div class="menu-header">
🍽️ HALAL BITES MENU
</div>

<form action="invoice.php" method="post">

<!-- Customer Info -->
<div class="customer-box">
    <h3>Customer Information</h3>
    <input type="text" name="name" placeholder="Enter Name" required>
    <input type="text" name="phone" placeholder="Enter Phone" required>
</div>

<!-- Menu Items -->
<div class="menu-grid">

<?php
$res = $conn->query("SELECT * FROM products");

while($row = $res->fetch_assoc()){
?>

<div class="menu-item">
    <div>
        <strong><?php echo $row['name']; ?></strong><br>
        <span><?php echo $row['price']; ?> Tk</span>
    </div>

    <input type="number" name="qty[<?php echo $row['id']; ?>]" min="0" value="0">
</div>

<?php } ?>

</div>

<button class="order-btn">🛒 Place Order</button>

</form>

</div>

</body>
</html>