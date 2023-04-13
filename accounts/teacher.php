<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/SIS/config.php";


$lname = $fname = "";
// query the sql to get the firstname and lastname of user
$sql = "SELECT firstname, lastname FROM users WHERE id = ?";
if($stmt = $mysqli->prepare($sql)){
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("s", $param_id);
    
    // Set parameters
    $param_id = $_COOKIE["id"];
    
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

$news = "";
$sqlnews = "SELECT news FROM news";
if($stmt = $mysqli->prepare($sqlnews)){
    // Attempt to execute the prepared statement
    if($stmt->execute()){
        // Store result
        $stmt->store_result();
        
        // Check if username exists
        if($stmt->num_rows == 1){                    
            // Bind result variables
            $stmt->bind_result($news);
        }
    }
}
?>

<html>
<head>
    <title><?php echo $fname ?> Information</title>
    <?php require $path . 'req/head.php'; ?>
</head>
<body style="background-color:whitesmoke !important;">
    <?php require $path . 'req/navT.php'; ?>
    <div class="main">
    <h1>Welcome, <?php echo $fname ?></h1><br>
        <div class="row">
            <div class="col">
                <h3>News:</h3>
                <p style="font-size: 18px;"><?php echo $news; ?></p>
            </div>
        </div>
    </div>
</body>
</html>