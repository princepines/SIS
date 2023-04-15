<?php
// Create a bulk add subjects page can add multiple user and teacher can modify grades

require_once $_SERVER['DOCUMENT_ROOT'] . '/SIS/config.php';

$id = $subject = array();
$aid = "";
$id_err = $subject_err = $aid_err ="";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate Student ID
    if(empty(trim($_POST["id"]))){
        $id_err = "Please enter a Student ID.";
    } else{
        $id = explode(",", trim($_POST["id"]));
    }
    
    // Validate Subject
    if(empty(trim($_POST["subject"]))){
        $subject_err = "Please enter a subject.";
    } else{
        $subject = explode(",", trim($_POST["subject"]));
    }

    // Validate Adviser ID
    if(empty(trim($_POST["aid"]))){
        $aid_err = "Please enter an Adviser ID.";
    } else{
        $aid = trim($_POST["aid"]);
    }
    
    // check input errors and insert into database
    if(empty($id_err) && empty($subject_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO subjects (id, aid, subject) VALUES (?, ?, ?)";
        
        // insert subject as onw row for each student
        foreach($id as $i){
            // set subjects as one whole values
            $subjects = implode(",", $subject);
            if($stmt = $mysqli->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("sss", $param_id, $param_aid, $param_subject);
                
                // Set parameters
                $param_id = $i;
                $param_subject = $subjects;
                $param_aid = $aid;
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    echo "";
                } else{
                    echo '<script>alert("An Error Occured! Please try again later.")</script>';
                }
            }
        }
        echo '<script>alert("Successfully Added Subject to user!")</script>';
        // Close statement
        $stmt->close();
    }
    // Close connection
    $mysqli->close();
}
?>

<html>
<head>
    <title>Bulk Add Subjects</title>
    <?php require $path . 'req/head.php'; ?>
</head>
<body>
    <?php require $path . 'req/navR.php'; ?>
    <div class="container">
        <h1>Bulk Add Subjects to Students</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Student ID's</label>
                <input type="text" name="id" class="form-control">
            </div><br>
            <div class="form-group">
                <label>Adviser ID</label>
                <input type="text" name="aid" class="form-control">
            </div><br>
            <div class="form-group">
                <label>Subject Name</label><br>
                <small>Insert Subject name, separated with commas</small>
                <input type="text" name="subject" class="form-control">
            </div><br>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
        </form>
    </div>
</body>
</html>
<?php
// Create a bulk add subjects page can add multiple user and teacher can modify grades

require_once $_SERVER['DOCUMENT_ROOT'] . '/SIS/config.php';

$id = $subject = array();
$aid = "";
$id_err = $subject_err = $aid_err ="";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate Student ID
    if(empty(trim($_POST["id"]))){
        $id_err = "Please enter a Student ID.";
    } else{
        $id = explode(",", trim($_POST["id"]));
    }
    
    // Validate Subject
    if(empty(trim($_POST["subject"]))){
        $subject_err = "Please enter a subject.";
    } else{
        $subject = explode(",", trim($_POST["subject"]));
    }

    // Validate Adviser ID
    if(empty(trim($_POST["aid"]))){
        $aid_err = "Please enter an Adviser ID.";
    } else{
        $aid = trim($_POST["aid"]);
    }
    
    // check input errors and insert into database
    if(empty($id_err) && empty($subject_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO subjects (id, aid, subject) VALUES (?, ?, ?)";
        
        // insert subject as onw row for each student
        foreach($id as $i){
            // set subjects as one whole values
            $subjects = implode(",", $subject);
            if($stmt = $mysqli->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("sss", $param_id, $param_aid, $param_subject);
                
                // Set parameters
                $param_id = $i;
                $param_subject = $subjects;
                $param_aid = $aid;
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    echo "";
                } else{
                    echo '<script>alert("An Error Occured! Please try again later.")</script>';
                }
            }
        }
        echo '<script>alert("Successfully Added Subject to user!")</script>';
        // Close statement
        $stmt->close();
    }
    // Close connection
    $mysqli->close();
}
?>

<html>
<head>
    <title>Bulk Add Subjects</title>
    <?php require $path . 'req/head.php'; ?>
</head>
<body>
    <?php require $path . 'req/navR.php'; ?>
    <div class="container">
        <h1>Bulk Add Subjects to Students</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Student ID's</label>
                <input type="text" name="id" class="form-control">
            </div><br>
            <div class="form-group">
                <label>Adviser ID</label>
                <input type="text" name="aid" class="form-control">
            </div><br>
            <div class="form-group">
                <label>Subject Name</label><br>
                <small>Insert Subject name, separated with commas</small>
                <input type="text" name="subject" class="form-control">
            </div><br>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
        </form>
    </div>
</body>
</html>
