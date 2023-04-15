<?php
// records grades from specific subject and student
require_once $_SERVER['DOCUMENT_ROOT'] . '/SIS/config.php';

$id = $subject = $grade = "";
$id_err = $subject_err = $grade_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate Student ID
    if(empty(trim($_POST["id"]))){
        $id_err = "Please enter a Student ID.";
    } else{
        $id = trim($_POST["id"]);
    }
    
    // Validate Subject
    if(empty(trim($_POST["subject"]))){
        $subject_err = "Please enter a subject id.";
    } else{
        $subject = trim($_POST["subject"]);
    }
    
    // Validate Grade
    if(empty(trim($_POST["grade"]))){
        $grade_err = "Please enter a grade.";
    } else{
        $grade = trim($_POST["grade"]);
    }
    
    // check input errors and insert into database
    if(empty($id_err) && empty($subject_err) && empty($grade_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO grades (id,subject,grade) VALUES (?, ?, ?)";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sss", $param_id, $param_subject, $param_grade);
            
            // Set parameters
            $param_id = $id;
            $param_subject = $subject;
            $param_grade = $grade;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                echo '<script>alert("Successfully Added Grade!")</script>';
            } else{
                echo '<script>alert("An Error Occured! Please try again later.")</script>';
            }
        }
        // Close statement
        $stmt->close();
    }
}
?>

<html>
    <head>
        <title>Grades</title>
        <?php require $path . 'req/head.php'; ?>
    </head>
    <body>
        // form to insert student id and grade on subject assigned to teacher
        <?php require $path . 'req/navT.php'; ?>
        <div class="container">
        <h1>Submit Grades</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Student ID</label>
                <input type="text" name="id" class="form-control">
            </div><br>
            <div class="form-group">
                <label>Subject</label>
                <input type="text" name="subject" class="form-control">
            <div class="form-group">
                <label>Grade</label>
                <input type="text" name="grade" class="form-control">
            </div><br>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
        </form>
    </div>
    </body>
</html>