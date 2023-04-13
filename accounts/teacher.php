<?php
require_once "config.php";

$lname = $fname = "";
// query the sql to get the firstname and lastname of user
$sql = "SELECT firstname, lastname FROM users WHERE id = ?";
if($stmt = $mysqli->prepare($sql)){
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("s", $param_id);
    
    // Set parameters
    $param_id = $_SESSION["id"];
    
    // Attempt to execute the prepared statement
    if($stmt->execute()){
        // Store result
        $stmt->store_result();
        
        // Check if username exists, if yes then verify password
        if($stmt->num_rows == 1){                    
            // Bind result variables
            $stmt->bind_result($fname, $lname);
        }
    }
}
?>

<html>
    <head>
        <title>Hello <?php echo $fname; ?></title>
    </head>
    <body>
        // nav bar
        <?php include 'nav.php'; ?>
        
    </body>
</html>