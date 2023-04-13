<?php
$loc = str_replace("accounts", "", __DIR__);
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
        
        // Check if username exists
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

// fetch the subjects of the user
$subjects = array();
$sqlsub = "SELECT subject FROM subjects WHERE id = ?";
if($stmt = $mysqli->prepare($sqlsub)){
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("s", $param_id);
    
    // Set parameters
    $param_id = $_SESSION["id"];
    
    // Attempt to execute the prepared statement
    if($stmt->execute()){
        // Store result
        $stmt->store_result();
        
        // Check if username exists
        if($stmt->num_rows == 1){                    
            // Bind result variables
            $stmt->bind_result($subjects);
        }
    }
}
?>

<html>
<head>
    <title>Hello <?php //echo $fname; ?></title>
    <?php require $loc . 'req/head.php'; ?>
</head>
<body style="background-color:whitesmoke !important;">
    <?php require $loc . 'req/navS.php'; ?>
    <div class="main">
        <h1>Welcome, <?php //echo $fname; ?></h1><br>
        <div class="row">
            <div class="col">
                <h3>News:</h3>
                <p style="font-size: 18px;"><?php echo "test";//echo $news; ?></p>
            </div>
            <div class="col">
                <h3>Subjects</h3>
                <ul>
                    <?php
                    //foreach($subjects as $subject){
                    //    echo "<li>" . $subject . "</li>";
                    //}
                    ?>
            </div>
        </div>
    </div>
</body>
</html>