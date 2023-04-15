<?php
// show subjects of a specific student

require_once $_SERVER['DOCUMENT_ROOT'] . '/SIS/config.php';
?>

<html>
<head>
    <title>Payment Records</title>
    <?php require $path . 'req/head.php'; ?>
</head>
<body>
    <?php require $path . 'req/navS.php'; ?>
    <div class="container">
        <h1>Enlisted Subjects and Recorded Grades</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Subjects</th>
                    <th scope="col">Grades</th>
                </tr>
            </thead>
            <tbody>
                <?php
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
                        
                        // check subjects seperate from comma to table
                        if($stmt->num_rows == 1){                    
                            // Bind result variables
                            $stmt->bind_result($subject);
                            if($stmt->fetch()){
                                (array)$subject = explode(",", $subject);
                                foreach($subject as $s){
                                    echo "<tr><td>" . $s . "</td></tr>";
                                }
                            }
                        }
                    }
                }
                // do grades section
                $sql = "SELECT grade FROM grades WHERE id = ?";
                if($stmt = $mysqli->prepare($sql)){
                    // Bind variables to the prepared statement as parameters
                    $stmt->bind_param("s", $param_id);
                    
                    // Set parameters
                    $param_id = $_COOKIE["id"];
                    
                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        // Store result
                        $stmt->store_result();
                        
                        // check subjects seperate from comma to table
                        if($stmt->num_rows == 1){                    
                            // Bind result variables
                            $stmt->bind_result($grade);
                            if($stmt->fetch()){
                                (array)$grade = explode(",", $grade);
                                foreach($grade as $g){
                                    echo "<tr><td>" . $g . "</td></tr>";
                                }
                            }
                        }
                    }
                }
                // compute the grades and display the average
                $sql = "SELECT grade FROM grades WHERE id = ?";
                if($stmt = $mysqli->prepare($sql)){
                    // Bind variables to the prepared statement as parameters
                    $stmt->bind_param("s", $param_id);
                    
                    // Set parameters
                    $param_id = $_COOKIE["id"];
                    
                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        // Store result
                        $stmt->store_result();
                        
                        // check subjects seperate from comma to table
                        if($stmt->num_rows == 1){                    
                            // Bind result variables
                            $stmt->bind_result($grade);
                            if($stmt->fetch()){
                                (array)$grade = explode(",", $grade);
                                $sum = 0;
                                foreach($grade as $g){
                                    $sum += $g;
                                }
                                $average = $sum / count($grade);
                                echo "<tr><td>Average: " . $average . "</td></tr>";
                            }
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </body>
    </html>