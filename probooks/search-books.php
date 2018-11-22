<?php

// check whether user is already logged in or not
// $config = include '/config/db.php';
$username = $_COOKIE['username'];
$access_token = $_COOKIE['access_token'];
$id = $_COOKIE['id'];

if (!isset($username) or !isset($access_token) or !isset($id)) {
    // check if variables not null, if null redirect to login
    header('Location: login.php');
} elseif ($id == $access_token.$username) {
    // do nothing
} else {
    //redirect to login page
    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Search Book Page</title>
        <link rel="stylesheet" type="text/css" href="public/css/navbar.css">
        <link rel="stylesheet" type="text/css" href="public/css/body.css">
        <link rel="stylesheet" type="text/css" href="public/css/search-books.css">
    </head>
    <body>
        <div id="nav">
            <ul>
                <li id="li-pro-book"><a href="search-books.php" id="pro-book">
                    <span class="text-yellow">Pro</span><span class="text-white">-Book</span>
                </a></li>
                <li id="li-username"><a href="profile.php" id="username" class="text-white">Hi, <?php echo "$username"; ?></a></li>
                <li id="li-logout"><a href="logout.php" id="logout" class="text-white">
                    <img src="public/img/power.png" alt="Logout" height="30" width="30">
                </a></li>
            </ul>
            <ul id="menu">
                <li><a class="active text-white" href="search-books.php">Browse</a></li>
                <li><a class="text-white" href="history.php">History</a></li>
                <li><a class="text-white" href="profile.php">Profile</a></li>
            </ul>
        </div>
        <div class="content">
            <div class="container text-align-left">
                <h2 class="text-orange">Search Book</h2>
            </div>
            <div class="container text-align-right">
                <form name="search" action="search-result.php" method="get" onsubmit="return validate()">
                    <input type="text" name="search-box" class="input" id="search-box" placeholder="Input search terms...">
                    <input type="submit" value="Search" class="input text-white" id="submit-button">
                </form>
            </div>
        </div>
    </body>

    <script>
        function validate() {
            var search = document.forms["search"]["search-box"].value;
            
            if (search == "") { //field empty
                alert("Fields must be filled out");
                return false;
            }
        }
    </script>
</html>
