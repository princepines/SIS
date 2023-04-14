<?php

// Include config file
require_once $_SERVER['DOCUMENT_ROOT'] . "/SIS/config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $account = "";
$username_err = $password_err = $confirm_password_err = "";
$fname = $mname = $lname = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    //Validate First, Middle nad Last
    if(empty(trim($_POST["fname"]))){
        $fname_err = "Please enter a first name.";
    } else{
        $fname = trim($_POST["fname"]);
    }
    if(empty(trim($_POST["mname"]))){
        $mname_err = "Please enter a middle name.";
    } else{
        $mname = trim($_POST["mname"]);
    }
    if(empty(trim($_POST["lname"]))){
        $lname_err = "Please enter a last name.";
    } else{
        $lname = trim($_POST["lname"]);
    }

    // Validate Account type
    if(empty(trim($_POST["account"]))){
        $account_err = "Please enter an account type.";
    } else{
        $account = trim($_POST["account"]);
    }

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 8){
        $password_err = "Password must have atleast 8 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, account, firstname, middlename, lastname) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssss", $param_username, $param_password, $param_account, $param_fname, $param_mname, $param_lname);
            
            // Set parameters
            $param_fname = $fname;
            $param_mname = $mname;
            $param_lname = $lname;
            $param_account = $account;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                echo '<script>alert("Successfully Added User!")</script>';
            } else{
                echo '<script>alert("An Error Occured! Please try again later.")</script>';
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $mysqli->close();
}
?>
 
<html>
<head>
    <?php require $path . 'req/head.php'; ?>
</head>
<body>
    <?php require $path . 'req/navR.php'; ?>
    <div class="container">
        <h2>Register User</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="fname" class="form-control ">
            </div>
            <div class="form-group">
                <label>Middle Name</label>
                <input type="text" name="mname" class="form-control ">
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="lname" class="form-control ">
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control  ">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control  " value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Account Type</label>
                <select name="account" class="form-control">
                    <option value="student">Student</option>
                    <option value="cashier">Cashier</option>
                    <option value="registrar">Registrar</option>
                    <option value="teacher">Teacher</option>
                </select>
            </div><br>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
        </form>
    </div>    
</body>
</html>