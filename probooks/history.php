<?php

// check whether user is already logged in or not
// $config = include '/config/db.php';
$username = $_COOKIE['username'];
$access_token = $_COOKIE['access_token'];
$id = $_COOKIE['id'];

if ($id == $access_token.$username) {
    $config = include 'config/db.php';
    $conn = mysqli_connect($config['host'], $config['username'], $config['password'], $config['db_name']);
        if (!$conn) {
            die("Connection failed: " . $conn->connect_error);
        }
    
    $query = "SELECT ordering.id, bookid, username, title, author, description, image, count, date, IF(ISNULL(review.id), 0, 1) as reviewed
        FROM ordering join book on bookid=book.id 
	    left join review on ordering.id=review.orderid
        WHERE username=\"$username\"
        ORDER BY id desc";

    $result = mysqli_query($conn, $query);
} else {
    //redirect to login page
    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>History Page</title>
        <link rel="stylesheet" type="text/css" href="public/css/navbar.css">
        <link rel="stylesheet" type="text/css" href="public/css/body.css">
        <link rel="stylesheet" type="text/css" href="public/css/history.css">
        <div id="nav">
            <ul>
                <li id="li-pro-book"><a href="search.php" id="pro-book">
                    <span class="text-yellow">Pro</span><span class="text-white">-Book</span>
                </a></li>
                <li id="li-username"><a href="profile.php" id="username" class="text-white">Hi, <?php echo $_COOKIE['username'];?></a></li>
                <li id="li-logout"><a href="logout.php" id="logout" class="text-white">
                    <img src="public/img/power.png" alt="Logout" height="30" width="30">
                </a></li>
            </ul>
            <ul id="menu">
                <li><a class="text-white" href="search.php">Browse</a></li>
                <li><a class="active text-white" href="history.php">History</a></li>
                <li><a class="text-white" href="profile.php">Profile</a></li>
            </ul>
        </div>
    </head>
    <body>
        <p class="title">History</p>
        <div id="history-content">
            <?php 
                while($row = $result->fetch_assoc()) {
                    if ($row['reviewed'] == '1') {
                        echo"<div class='flex-container'>
                            <div class='book-info'> 
                                <img class='book-pict' src={$row['image']}>
                                <p class='book-title'>{$row['title']} </p>
                                <p class='book-content'>Jumlah: {$row['count']} <br>
                                Anda sudah memberikan review <br>
                            </div>
                            
                            <div class='buy-time'> 
                                <p class='buy-info'>";

                        echo date("j F Y", strtotime($row['date']));
                        echo"<br> Nomor Order: #{$row['id']}
                                </p>
                            </div>
                        </div>";
                    } else { 
                        echo"<div class='flex-container'>
                            <div class='book-info'> 
                                <img class='book-pict' src={$row['image']}>
                                <p class='book-title'>{$row['title']} </p>
                                <p class='book-content'>Jumlah: {$row['count']} <br>
                                Belum direview<br>
                            </div>
                            
                            <div class='buy-time'> 
                                <p class='buy-info'>";
                        echo date("j F Y", strtotime($row['date']));
                        echo"<br> Nomor Order: #{$row['id']}
                                <form method='POST' action='review.php'>
                                    <input type='hidden' id='order-id' name='orderId' value={$row['id']}>
                                    <input type='hidden' id='book-id' name='bookId' value={$row['bookid']}>
                                    <input class='review-button' type='submit' value='Review'>
                                </form>
                            </div>
                        </div>";
                    }
                }
            ?>
        </div>
    </body>
</html>