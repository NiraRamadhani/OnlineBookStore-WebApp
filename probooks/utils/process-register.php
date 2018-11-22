<?php
    //connect to database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "probooks";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    //get data from form
    $name = $_POST['name'];
    $uname = $_POST['username'];
    $pw = $_POST['password'];
    $email = $_POST['email'];
    $adr = $_POST['address'];
    $phone = $_POST['phone'];

    //create query
    if (isset($name, $uname, $pw, $email, $adr, $phone)) {
        $query = "INSERT INTO user VALUES('$uname', '$pw', '$name', '$phone', '$adr', '$email', 'public/img/profpic/default.jpg');";
        //execute query
        if ($conn->query($query) === TRUE) {
            $access_token = bin2hex(random_bytes(16));
            setcookie('username', $uname, time() + 3600, '/');
            setcookie('access_token', $access_token, time() + 3600, '/');
            setcookie('id', $access_token . $uname, false, '/');
            header('Location: ../search-books.php');
        }
    }
        
    $conn->close();
?>