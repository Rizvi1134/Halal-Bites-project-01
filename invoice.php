<?php
include 'db.php';

$name = $_POST['name'];
$phone = $_POST['phone'];

$conn->query("INSERT INTO customers(name, phone) VALUES('$name','$phone')");
$customer_id = $conn->insert_id;

$total = 0;
$items = [];

foreach($_POST['qty'] as $pid => $qty){
    if($qty > 0){
        $res = $conn->query("SELECT * FROM products WHERE id=$pid");
        $row = $res->fetch_assoc();

        $price = $row['price'];
        $item_total = $price * $qty;

        $total += $item_total;

        $items[] = [
            "name" => $row['name'],
            "qty" => $qty,
            "price" => $price,
            "subtotal" => $item_total
        ];
    }
}

$discount_percent = 0;

if($total >= 1000){
    $discount_percent = 10;
}

$discount_amount = ($total * $discount_percent) / 100;
$final = $total - $discount_amount;

$conn->query("INSERT INTO orders(customer_id,total_amount,discount,final_amount)
VALUES($customer_id,$total,$discount_amount,$final)");

$order_id = $conn->insert_id;
?>

<!DOCTYPE html>
<html>
<head>
<title>Invoice</title>

<style>
body {
    font-family: Arial;
    background: #f0f2f5;
    margin: 0;
}

/* Header like Facebook */
.header {
    background: #1877f2;
    color: white;
    padding: 20px;
    font-size: 22px;
    font-weight: bold;
}

/* Main box */
.invoice-box {
    width: 70%;
    margin: 30px auto;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th {
    background: #1877f2;
    color: white;
    padding: 10px;
}

td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

/* Summary box */
.summary {
    margin-top: 20px;
    padding: 15px;
    background: #f9f9f9;
    border-radius: 10px;
}

/* Print button */
button {
    background: #1877f2;
    color: white;
    border: none;
    padding: 10px 15px;
    margin-top: 20px;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background: #0d65d9;
}
</style>
</head>

<body>

<div class="header">
🍽️ Halal Bites Invoice
</div>

<div class="invoice-box">

<h3>Customer Info</h3>
<p><b>Name:</b> <?php echo $name; ?></p>
<p><b>Phone:</b> <?php echo $phone; ?></p>

<h3>Order Details</h3>

<table>
<tr>
<th>Item</th>
<th>Qty</th>
<th>Price</th>
<th>Subtotal</th>
</tr>

<?php foreach($items as $it){ ?>
<tr>
<td><?php echo $it['name']; ?></td>
<td><?php echo $it['qty']; ?></td>
<td><?php echo $it['price']; ?></td>
<td><?php echo $it['subtotal']; ?></td>
</tr>
<?php } ?>

</table>

<div class="summary">
<p><b>Subtotal:</b> <?php echo $total; ?> Tk</p>
<p><b>Discount:</b> <?php echo $discount_percent; ?>% (<?php echo $discount_amount; ?> Tk)</p>
<h3><b>Final Total:</b> <?php echo $final; ?> Tk</h3>
</div>

<button onclick="window.print()">🖨️ Print Invoice</button>

</div>

</body>
</html>