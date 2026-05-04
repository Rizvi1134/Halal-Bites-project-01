<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f0f2f5;
        }

        .navbar {
            background: linear-gradient(45deg, #1877f2, #42a5f5);
        }

        .card {
            border: none;
            border-radius: 15px;
            transition: 0.3s;
        }

        .card:hover {
            transform: scale(1.03);
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }

        .title {
            font-weight: bold;
            color: #1877f2;
        }

        .btn-blue {
            background: #1877f2;
            color: white;
        }

        .btn-blue:hover {
            background: #0d65d9;
        }
    </style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-dark p-3">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">🍽️ Halal Bites Admin</span>
        <a href="index.php" class="btn btn-light">Logout</a>
    </div>
</nav>

<div class="container mt-4">

    <div class="row">

        <!-- Total Earnings -->
        <div class="col-md-4">
            <div class="card p-4 text-center">
                <h5 class="title">Total Earnings</h5>
                <?php
                $res = $conn->query("SELECT SUM(final_amount) as total FROM orders");
                $row = $res->fetch_assoc();
                ?>
                <h2><?php echo $row['total'] ?? 0; ?> Tk</h2>
            </div>
        </div>

        <!-- Orders Count -->
        <div class="col-md-4">
            <div class="card p-4 text-center">
                <h5 class="title">Total Orders</h5>
                <?php
                $res = $conn->query("SELECT COUNT(*) as total FROM orders");
                $row = $res->fetch_assoc();
                ?>
                <h2><?php echo $row['total']; ?></h2>
            </div>
        </div>

        <!-- Customers -->
        <div class="col-md-4">
            <div class="card p-4 text-center">
                <h5 class="title">Total Customers</h5>
                <?php
                $res = $conn->query("SELECT COUNT(*) as total FROM customers");
                $row = $res->fetch_assoc();
                ?>
                <h2><?php echo $row['total']; ?></h2>
            </div>
        </div>

    </div>

    <!-- Sales Table -->
    <div class="card p-4 mt-4">
        <h4 class="title">📊 Food Sales Report</h4>

        <table class="table table-hover mt-3">
            <thead class="table-primary">
                <tr>
                    <th>Item</th>
                    <th>Sold Quantity</th>
                </tr>
            </thead>

            <tbody>
            <?php
            $res = $conn->query("
            SELECT products.name, SUM(order_details.quantity) as qty
            FROM order_details
            JOIN products ON products.id = order_details.product_id
            GROUP BY product_id
            ");

            while($row = $res->fetch_assoc()){
                echo "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['qty']}</td>
                      </tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <!-- Search -->
    <div class="card p-4 mt-4">
        <h4 class="title">🔍 Search Customer</h4>

        <form method="post" class="d-flex gap-2 mt-3">
            <input type="text" name="phone" class="form-control" placeholder="Enter phone number">
            <button name="search" class="btn btn-blue">Search</button>
        </form>

        <?php
        if(isset($_POST['search'])){
            $phone = $_POST['phone'];

            $res = $conn->query("
            SELECT customers.name, orders.final_amount, orders.order_date
            FROM orders
            JOIN customers ON customers.id = orders.customer_id
            WHERE customers.phone='$phone'
            ");

            echo "<table class='table mt-4'>";
            echo "<tr class='table-primary'>
                    <th>Name</th>
                    <th>Total</th>
                    <th>Date</th>
                  </tr>";

            while($row = $res->fetch_assoc()){
                echo "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['final_amount']}</td>
                        <td>{$row['order_date']}</td>
                      </tr>";
            }

            echo "</table>";
        }
        ?>
    </div>

</div>

</body>
</html>