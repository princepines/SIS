<?php
// Show all payment Records of specific user
require_once $_SERVER['DOCUMENT_ROOT'] . '/SIS/config.php';

//convert student id to name
function getStudentName($id){
    global $mysqli;
    $sql = "SELECT firstname, lastname FROM users WHERE id = ?";
    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("s", $param_id);
        
        // Set parameters
        $param_id = $id;
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Store result
            $stmt->store_result();
            
            // Check if username exists
            if($stmt->num_rows == 1){                    
                // Bind result variables
                $stmt->bind_result($fname, $lname);
                if($stmt->fetch()){
                    return $fname . " " . $lname;
                }
            }
        }
    }
}
?>

<html>
    <head>
        <title>Payment Records</title>
        <?php require $path . 'req/head.php'; ?>
    </head>
    <body>
        <?php require $path . 'req/navS.php'; ?>
        <div class="container">
            <h1>Payment Records</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Payment Type</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT paymentid, id, amount, paymenttype, created_at FROM payments where id = ?";
                    if($stmt = $mysqli->prepare($sql)){
                        // Bind variables to the prepared statement as parameters
                        $stmt->bind_param("s", $param_id);
                        
                        // Set parameters
                        $param_id = $_COOKIE['id'];
                        
                        // Attempt to execute the prepared statement
                        if($stmt->execute()){
                            // Store result
                            $stmt->store_result();
                            
                            // Check if username exists
                            if($stmt->num_rows >= 1){                    
                                // Bind result variables
                                $stmt->bind_result($id, $studentid, $amount, $paymenttype, $date);
                                while($stmt->fetch()){
                                    echo "<tr>";
                                    echo "<td>" . $id . "</td>";
                                    echo "<td>" . getStudentName($studentid) . "</td>";
                                    echo "<td>" . $amount . "</td>";
                                    echo "<td>" . $paymenttype . "</td>";
                                    echo "<td>" . $date . "</td>";
                                    echo "</tr>";
                                }
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
    </body>
</html>