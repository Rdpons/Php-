<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["register"])) {
        $idno = !empty(trim($_POST["idno"])) ? trim($_POST["idno"]) : null;
        $firstName = !empty(trim($_POST["firstName"])) ? trim($_POST["firstName"]) : null;
        $middleName = !empty(trim($_POST["middleName"])) ? trim($_POST["middleName"]) : null;
        $lastName = !empty(trim($_POST["lastName"])) ? trim($_POST["lastName"]) : null;
        $password = !empty(trim($_POST["password"])) ? trim($_POST["password"]) : null;
        $age = !empty(trim($_POST["age"])) ? trim($_POST["age"]) : null;
        $gender = !empty(trim($_POST["gender"])) ? trim($_POST["gender"]) : null;
        $contactNo = !empty(trim($_POST["contactNo"])) ? trim($_POST["contactNo"]) : null;
        $email = !empty(trim($_POST["email"])) ? trim($_POST["email"]) : null;
        $address = !empty(trim($_POST["address"])) ? trim($_POST["address"]) : null;

        $sql = "INSERT INTO users (idno, firstname, middlename, lastname, password, age, gender, contactno, email, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssssssssss", $idno, $firstName, $middleName, $lastName, $password, $age, $gender, $contactNo, $email, $address);
            if (mysqli_stmt_execute($stmt)) {
                header("location: login.php");
                exit;
            } else {
                echo "Error: " . mysqli_error($link);
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Process login form
    if (isset($_POST["login"])) {
        $email = $password = "";
        $email_err = $password_err = $login_err = "";

        if (empty(trim($_POST["email"]))) {
            $email_err = "Please enter your email.";
        } else {
            $email = trim($_POST["email"]);
        }

        if (empty(trim($_POST["password"]))) {
            $password_err = "Please enter your password.";
        } else {
            $password = trim($_POST["password"]);
        }

        if (empty($email_err) && empty($password_err)) {
            $sql = "SELECT id, email, password FROM users WHERE email = ?";
            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $param_email);
                $param_email = $email;
                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);
                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
                        if (mysqli_stmt_fetch($stmt)) {
                            if (password_verify($password, $hashed_password)) {
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["email"] = $email;
                                header("location: dashboard.php");
                                exit;
                            } else {
                                $login_err = "Invalid email or password.";
                            }
                        }
                    } else {
                        $login_err = "Invalid email or password.";
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
                mysqli_stmt_close($stmt);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Login</title>
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Montserrat', sans-serif;
}

body{
    background-color: #fff;
    
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    height: 100vh;
}

.container {
    background-color: #a8a29c;
    border-radius: 30px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
    position: relative;
    overflow: hidden;
    width: 768px;
    max-width: 1000px;
    min-height: 690px; 
}

.container p{
    font-size: 14px;
    line-height: 20px;
    letter-spacing: 0.3px;
    margin: 20px 0;
}

.container span{
    font-size: 12px;
}

.container a{
    color: #a8a29c;
    font-size: 13px;
    text-decoration: none;
    margin: 15px 0 10px;
}

.container button {
    background-color: #50413c;
    color: #fff;
    font-size: 12px;
    padding: 10px 45px;
    border: 1px solid transparent;
    border-radius: 8px;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    margin-top: 10px;
    cursor: pointer;
}

.custom-select:focus {
    border: 2px solid #50413c;
    background-color: #a8a29c;
}

.toggle {
    background-color: #50413c;
    height: 100%;
    color: #fff;
    position: relative;
    left: -100%;
    height: 100%;
    width: 200%;
    transform: translateX(0);
    transition: all 0.6s ease-in-out;
}

.container button.hidden{
    background-color: transparent;
    border-color: #fff;
}

.container form{
    background-color: #a8a29c;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 40px;
    height: 100%;
}

.container input{
    background-color: #eee;
    border: none;
    margin: 8px 0;
    padding: 10px 15px;
    font-size: 13px;
    border-radius: 8px;
    width: 100%;
    outline: none;
}
.sign-in h1,
.sign-up h1 {
    color: #fff;
}
.form-container{
    position: absolute;
    top: 0;
    height: 100%;
    transition: all 0.6s ease-in-out;
}

.sign-in{
    left: 0;
    width: 50%;
    z-index: 2;
}

.container.active .sign-in{
    transform: translateX(100%);
}

.sign-up{
    left: 0;
    width: 50%;
    opacity: 0;
    z-index: 1;
}

.container.active .sign-up{
    transform: translateX(100%);
    opacity: 1;
    z-index: 5;
    animation: move 0.6s;
}

@keyframes move{
    0%, 49.99%{
        opacity: 0;
        z-index: 1;
    }
    50%, 100%{
        opacity: 1;
        z-index: 5;
    }
}
.toggle-panel img {
    width: 300px; 
    height: 300px; 
    border-radius: 50%; 
}
.toggle-container{
    position: absolute;
    top: 0;
    left: 50%;
    width: 50%;
    height: 100%;
    overflow: hidden;
    transition: all 0.6s ease-in-out;
    border-radius: 150px 0 0 100px;
}

.container.active .toggle-container{
    transform: translateX(-100%);
    border-radius: 0 150px 100px 0;
}

.toggle{
    background-color: #50413c;
    height: 100%;
    color: #fff;
    position: relative;
    left: -100%;
    height: 100%;
    width: 200%;
    transform: translateX(0);
    transition: all 0.6s ease-in-out;
}

.container.active .toggle{
    transform: translateX(50%);
}

.toggle-panel{
    position: absolute;
    width: 50%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 30px;
    text-align: center;
    top: 0;
    transform: translateX(0);
    transition: all 0.6s ease-in-out;
}

.toggle-left{
    transform: translateX(-200%);
}

.container.active .toggle-left{
    transform: translateX(0);
}

.toggle-right{
    right: 0;
    transform: translateX(0);
}

.container.active .toggle-right{
    transform: translateX(200%);
}
.custom-select {
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  background-color: #eee;
  border: none;
  padding: 10px 15px;
  font-size: 13px;
  border-radius: 8px;
  width: 100%;
  color: gray;
  outline: none;
  cursor: pointer;
}
.custom-select:after {
  content: '\25BC'; 
  position: absolute;
  top: 50%;
  right: 15px;
  transform: translateY(-50%);
  pointer-events: none;
}

.custom-select:focus {
  border: 2px solid #50413c;
  background-color: #fff;
}
#address {
    background-color: #eee;
    border: none;
    margin: 8px 0;
    padding: 10px 15px;
    font-size: 13px;
    border-radius: 8px;
    width: 100%;
    outline: none;
    resize: vertical;
}
    </style>
<body>

    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="register.php" method="post">
                <h1>Create Account</h1>
                <input type="text" name="id" placeholder="Id number">
                <input type="text" name="firstName" placeholder="First Name">
                <input type="text" name="middleName" placeholder="Middle Name">
                <input type="text" name="lastName" placeholder="Last Name">
                <input type="password" name="password" placeholder="Password">
                <input type="text" name="age" placeholder="Age">
                <select name="gender" id="gender" class="custom-select">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <input type="text" name="contactNo" placeholder="Contact No">
                <input type="email" name="email" placeholder="Email">
                <textarea name="address" id="address" cols="10" rows="4" placeholder="Address"></textarea>
                <input type="hidden" name="register" value="1"> <!-- Add this hidden input field -->
                <button type="submit">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in">
                <form action="login.php" method="post">
                    <input type="email" name="email" placeholder="Email">
                    <input type="password" name="password" placeholder="Password">
                    <button type="submit">Sign In</button>
                </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <img src=".\images\Logo.png">
                    <button class="hidden" id="signin">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <img src=".\images\Logo.png">
                    <button class="hidden" id="signup">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const container = document.getElementById('container');
        const signinBtn = document.getElementById('signin');
        const signupBtn = document.getElementById('signup');

        signupBtn.addEventListener('click', () => {
            container.classList.add("active");
        });

        signinBtn.addEventListener('click', () => {
            container.classList.remove("active");
        });
    </script>
</body>

</html>
