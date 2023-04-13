// Show all payment Records

<?php
$loc = str_replace("forms/cashier", "", __DIR__);

require_once $loc . 'config.php';
?>

<html>
    <head>
        <title>Payment Records</title>
        <?php require $loc . 'req/head.php'; ?>
    </head>
    <body>
        <?php require $loc . 'req/navC.php'; ?>
        <div class="container">
            <h1>Payment Records</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Payment Type</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT id, amount, paymenttype, date FROM payments";
                    if($stmt = $mysqli->prepare($sql)){
                        // Attempt to execute the prepared statement
                        if($stmt->execute()){
                            // Store result
                            $stmt->store_result();
                            
                            // Check if username exists
                            if($stmt->num_rows > 0){                    
                                // Bind result variables
                                $stmt->bind_result($id, $amount, $paymenttype, $date);
                                while($stmt->fetch()){
                                    echo "<tr>
                                            <td>$id</td>
                                            <td>$amount</td>
                                            <td>$paymenttype</td>
                                            <td>$date</td>
                                        </tr>";
                                }
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
    </body>
</html>