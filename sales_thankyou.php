<?php
session_start();
@include 'config.php'; // Include your DB config file

// Fetch the last order from the 'sales' table
$sql = "SELECT * FROM `sales` ORDER BY `srno` DESC LIMIT 1";
$result = mysqli_query($conn, $sql);

// Check if any record was found
if ($result && mysqli_num_rows($result) > 0) {
    $order = mysqli_fetch_assoc($result); // Get the last order details
} else {
    echo "<script>alert('No order found.');</script>";
    die(); // Stop further execution if no record is found
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="image/logo.png">
    <title>Thank You</title>
    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.item td{
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        .print-btn {
            margin-top: 20px;
            text-align: center;
        }
        .logo {
            display: flex;
            align-items: center;
        }
        .logo img {
            width: 50px;
            height: auto;
            margin-right: 10px;
        }
        .logo h1 {
            font-size: 1.8rem;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <div class="logo">
                                    <img src="image/logo.png" alt="Bookish Logo">
                                    <h1>Bookish</h1>
                                </div>
                            </td>
                            <td>
                                Order Date: <?php echo date("Y/m/d", strtotime($order['date'])); ?><br>
                                Order #: <?php echo $order['srno']; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>Customer Details:</strong><br>
                                <?php echo $order['name']; ?><br>
                                Contact: <?php echo $order['contact_no']; ?>
                            </td>

                            <td>
                                <strong>Bookish..</strong><br>
                                infobookish@gmail.com<br>
                                +91 9175442260
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Payment Method</td>
                <td><?php echo ucfirst($order['payment_method']); ?></td>
            </tr>

            <tr class="heading">
                <td>Item Details</td>
                <td>Amount</td>
            </tr>

            <tr class="item">
                <td>
                    Item Name: <?php echo $order['item_name']; ?><br>
                    Category: <?php echo $order['category']; ?><br>
                    Quantity: <?php echo $order['quantity']; ?>
                </td>
                <td>₹<?php echo $order['price'] * $order['quantity']; ?></td>
            </tr>

            <tr class="item last">
                <td>Platform Convenience Fee</td>
                <td>₹<?php echo $order['platform_fee']; ?></td>
            </tr>

            <tr class="total">
                <td></td>
                <td>Total: ₹<?php echo $order['platform_fee']; ?></td>
            </tr>
        </table>

        <div class="print-btn">
    <button onclick="window.print()" class="btn btn-primary">Print Invoice</button>
    <a href="inde.php" class="btn btn-secondary">Home</a>
</div>

    </div>
</body>
</html>
