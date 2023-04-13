<?php
/*
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    // Redirect user to student page if account is student
    if($_SESSION["account"] == "student"){
        header("location: accounts/student.php");
    }
    // Redirect user to teacher page if account is teacher
    elseif($_SESSION["account"] == "teacher"){
        header("location: accounts/teacher.php");
    }
    // Redirect user to cashier page if account is cashier
    elseif($_SESSION["account"] == "cashier"){
        header("location: accounts/cashier.php");
    }
    // Redirect user to registrar page if account is registrar
    elseif($_SESSION["account"] == "registrar"){
        header("location: accounts/registrar.php");
    }
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password, account FROM users WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();
                
                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1){                    
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password, $account);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["account"] = $account;                          
                            
                            // Redirect user to student page if account is student
                            if($account == "student"){
                                header("location: accounts/student.php");
                            }
                            // Redirect user to teacher page if account is teacher
                            elseif($account == "teacher"){
                                header("location: accounts/teacher.php");
                            }
                            // Redirect user to cashier page if account is cashier
                            elseif($account == "cashier"){
                                header("location: accounts/cashier.php");
                            }
                            // Redirect user to registrar page if account is registrar
                            elseif($account == "registrar"){
                                header("location: accounts/registrar.php");
                            }
                            
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            
            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $mysqli->close();
}
*/
?>

<html>
<head>
    <title>SIS Login</title>
    <?php require_once "req/head.php"; ?>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Login</h1>
                <p>Please fill in your credentials to login.</p>
                
                <?php 
                if(!empty($login_err)){
                    echo '<div class="alert alert-danger">' . $login_err . '</div>';
                }        
                ?>
                
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control">
                        <span class="invalid-feedback"><?php //echo $username_err; ?></span>
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control">
                        <span class="invalid-feedback"><?php //echo $password_err; ?></span><br>
                        <input type="submit" class="btn btn-primary mb-3" value="Login">
                        <button type="button"  class="btn btn-link mb-3" onclick="">Forgot Password?</button>
                </form>
            </div>
            <div class="col">
                <img src="welcome.png" alt="welcome" width="500" height="500">
            </div>
        </div>
    </div>
</body>
</html>