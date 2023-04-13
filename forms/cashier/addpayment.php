<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/SIS/config.php';

// Define variables and initialize with empty values
$id = $amount = $paymenttype = "";
$id_err = $amount_err = $paymenttype_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate Student ID
    if(empty(trim($_POST["id"]))){
        $id_err = "Please enter a Student ID.";
    } else{
        $id = trim($_POST["id"]);
    }
    
    // Validate Amount
    if(empty(trim($_POST["amount"]))){
        $amount_err = "Please enter an amount.";
    } else{
        $amount = trim($_POST["amount"]);
    }
    
    // Validate Payment Type
    if(empty(trim($_POST["paymenttype"]))){
        $paymenttype_err = "Please enter a payment type.";
    } else{
        $paymenttype = trim($_POST["paymenttype"]);
    }
    
    // Check input errors before inserting in database
    if(empty($id_err) && empty($amount_err) && empty($paymenttype_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO payments (id, amount, paymenttype, date) VALUES (?, ?, ?, ?)";
         
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssss", $param_id, $param_amount, $param_paymenttype, $param_date);
            
            // Set parameters
            $param_id = $id;
            $param_amount = $amount;
            $param_paymenttype = $paymenttype;
            $param_date = date("Y-m-d");
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                echo '<script>alert("Successfully Added User!")</script>';
            } else{
                echo '<script>alert("An Error Occured! Please try again later.")</script>';
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
}
?>

<html>
    <head>
        <title>Add Payment</title>
        <?php require $path . 'req/head.php'; ?>
    </head>
    <body>
        <?php require $path . 'req/navC.php'; ?>
        <div class="container">
        <h2>Add Payment</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Student ID</label>
                <input type="text" name="id" class="form-control">
            </div>
            <div class="form-group">
                <label>Amount</label>
                <input type="text" name="amount" class="form-control">
            </div>
            <div class="form-group">
                <label>Payment Type</label>
                <select name="paymenttype" class="form-control">
                    <option value="cash">Cash</option>
                    <option value="check">E-Payments</option>
                    <option value="credit">Promissory</option>
                </select>
            </div><br>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
        </form>
        </div>
    </body>
</html>