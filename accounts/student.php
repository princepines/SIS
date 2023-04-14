<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/SIS/config.php";

$fname = $lname = "";
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
        
        // Check if username exists
        if($stmt->num_rows == 1){                    
            // Bind result variables
            $stmt->bind_result($fname, $lname);
            if($stmt->fetch()){
                $fname = $fname;
                $lname = $lname;
            }
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


// fetch the subjects of the student
$sql = "SELECT subject FROM subjects WHERE id = ?";
if($stmt = $mysqli->prepare($sql)){
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("s", $param_id);
    
    // Set parameters
    $param_id = $_COOKIE["id"];
    
    // Attempt to execute the prepared statement
    if($stmt->execute()){
        // Store result
        $stmt->store_result();
        
        // Check if username exists
        if($stmt->num_rows == 1){                    
            // Bind result variables
            $stmt->bind_result($subject);
            while($stmt->fetch()){
                $subjects = explode(",", $subject);
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
    <?php require $path . 'req/navS.php'; ?>
    <div class="main">
        <h1>Welcome, <?php echo $fname ?></h1><br>
        <div class="row">
            <div class="col">
                <h3>News:</h3>
                <table class="table table striped">
                    <tbody>
                    <?php
                    for($i = 0; $i < count($t); $i++){
                        echo "<tr>";
                        echo '<th scope="col"><h3>' . $t[$i] . '</h3></th>';
                        echo "</tr>";
                        echo "<tr>";
                        echo '<td>' . $c[$i] . '<br><br><small>'. $d[$i] . '</td>';
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="col">
                <h3>Subjects</h3>
                <table class="table table striped">
                    <tbody>
                    <?php
                    foreach($subjects as $s){
                        echo "<tr>";
                        echo "<td>" . $s . "</td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>