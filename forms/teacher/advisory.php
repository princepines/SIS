<?php
// Check Class Advisories for assigned subjects
require_once $_SERVER['DOCUMENT_ROOT'] . '/SIS/config.php';

?>

<html>
    <head>
        <title>Advisory</title>
        <?php require $path . 'req/head.php'; ?>
    </head>
    <body>
        <?php require $path . 'req/navT.php'; ?>
        <div class="container">
            <h1>Advisory</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Subject</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT id, subject FROM subjects WHERE aid = ?";
                    if($stmt = $mysqli->prepare($sql)){
                        // Bind variables to the prepared statement as parameters
                        $stmt->bind_param("s", $param_aid);
                        
                        // Set parameters
                        $param_aid = $_COOKIE['id'];
                        
                        // Attempt to execute the prepared statement
                        if($stmt->execute()){
                            // Store result
                            $stmt->store_result();
                            
                            // Check if username exists
                            if($stmt->num_rows > 0){                    
                                // Bind result variables
                                $stmt->bind_result($id, $subject);
                                while($stmt->fetch()){
                                    echo "<tr>";
                                    echo "<td>" . $id . "</td>";
                                    echo "<td>" . getStudentName($id) . "</td>";
                                    echo "<td>" . $subject . "</td>";
                                    echo "</tr>";
                                }
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>