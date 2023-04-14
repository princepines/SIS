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

$t = $c = $d = array();
// query the sql to get the news and store it in $t, $c and $d
$sql = "SELECT title, content, created_at FROM news";
if($stmt = $mysqli->prepare($sql)){
    // Attempt to execute the prepared statement
    if($stmt->execute()){
        // Store result
        $stmt->store_result();
        
        // Check if username exists
        if($stmt->num_rows > 0){                    
            // Bind result variables
            $stmt->bind_result($title, $content, $date);
            while($stmt->fetch()){
                array_push($t, $title);
                array_push($c, $content);
                array_push($d, $date);
            }
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
    <?php require $path . 'req/navR.php'; ?>
    <div class="main">
        <h1>Welcome, <?php echo $fname ?></h1><br>
        <div class="row">
            <div class="col">
                <h3>News:</h3>
                <?php
                for($i = 0; $i < count($t); $i++){
                    echo "<h4>" . $t[$i] . "</h4>";
                    echo "<p>" . $c[$i] . "</p>";
                    echo "<p>" . $d[$i] . "</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>