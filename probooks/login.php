<?php

    if (isset($_COOKIE['username']) and isset($_COOKIE['access_token']) and isset($_COOKIE['id'])) {
        header('Location: search.php');  
    }

    $con = mysqli_connect("localhost","root","","probooks");

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    if (isset($_POST['username']) && isset($_POST['password'])) {
        
        $get_username = mysqli_real_escape_string($con, $_POST['username']);
        $get_password = mysqli_real_escape_string($con, $_POST['password']);
        $sql="SELECT * FROM user WHERE username = '$get_username' AND password = '$get_password'";

        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) == 1) {
            $access_token = bin2hex(random_bytes(16));
            setcookie('username', $_POST['username'], false, '/');
            setcookie('access_token', $access_token, false, '/');
            setcookie('id', $access_token.$_POST['username'], time() + 3600, '/');
            header('Location: search.php');
        } else {
            echo '<script>alert("Wrong username or password");</script>';
        }                   
    }

    $con->close();
?>

<!DOCTYPE html>
    <html>
        <head>
            <title>LOGIN</title>
            <link rel="stylesheet" type="text/css" href="public/css/login.css">
            <link rel="stylesheet" type="text/css" href="public/css/body.css">
        </head>
        <body>
            <div class="content">
                <h2>LOGIN</h2>
                <form name="login" method="post" onsubmit="return validate()" action="">
                    <center>
                        <table>
                            <tr>
                                <td>Username</td>
                                <td><input type="text" name="username"></td>
                            </tr>
                            <tr>
                                <td>Password</td>
                                <td><input type="password" name="password"></td>
                            </tr>
                        </table>
                    </center><br>
                        <a href="register.php">Don't have an account?</a><br><br>
                    <center>
                        <input type="submit" name="submit" value="LOGIN">
                    </center>
                </form>
            </div>
        </body>

        <script>
            function validate() {
                var uname = document.forms["login"]["username"].value;
                var pw = document.forms["login"]["password"].value;
                
                if (uname == "" || pw == "") { //field empty
                    alert("Fields must be filled out");
                    return false;
                }
            }
            function wrong() {
                alert("Wrong username or password");
            }
        </script>
    </html>

