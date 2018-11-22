<?php

// check whether user is already logged in or not
$username = $_COOKIE['username'];
$access_token = $_COOKIE['access_token'];
$id = $_COOKIE['id'];

if (!isset($username) or !isset($access_token) or !isset($id)) {
    // check if variables not null, if null redirect to login
    header('Location: login.php');
} elseif ($id == $access_token.$username) {
    $find = $_GET['search-box'];

    if (isset($find)) {
        $config = include 'config/db.php';
        $conn = mysqli_connect($config['host'], $config['username'], $config['password'], $config['db_name']);
        if (!$conn) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT book.id, title, author, description, image, COUNT(review.rating) AS count_votes, COALESCE(AVG(review.rating), 0) AS avg_votes
                FROM ordering RIGHT JOIN review ON ordering.id = review.orderid RIGHT JOIN book ON book.id = ordering.bookid
                WHERE title LIKE '%$find%'
                GROUP BY book.id";

        $result = mysqli_query($conn, $query);
    } else {
        //redirect to search-books page
        header('Location: search-books.php');
    }
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
        <link rel="stylesheet" type="text/css" href="public/css/search-result.css">
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
            <div class="container text-align-left title-content">
                <table class="full-width">
                    <tr>
                        <td id="search-title">
                            <h2 class="text-orange">Search Result</h2>
                        </td>
                        <td id="found-count" class="text-align-right vertical-align-bottom">
                            <p>Found <span id="num-rows"><?php echo "$result->num_rows";?></span> result(s)</p>
                        </td>
                    </tr>
                </table>
            </div>
            <div>
                <div class="container">
                    <table class="full-width">
                        <?php
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td class='picture vertical-align-top'>
                                        <img class='img-book' src={$row['image']}>
                                    </td>
                                    <td class='book-data text-align-left vertical-align-top'>
                                        <p class='title-book text-orange'>{$row['title']}</p>
                                        <p class='author-book'>{$row['author']} - " . number_format($row['avg_votes'],1) . "/5.0 ({$row['count_votes']} votes)</p>
                                        <p class='desc-book'>{$row['description']}</p>
                                    </td>
                                </tr>
                                <tr class='button-detail text-align-right'>
                                    <td colspan='2'>
                                        <form method='get' action='order.php'>
                                            <input type='hidden' id='book-id' name='bookid' value={$row['id']}>
                                            <input class='submit-button text-white' type='submit' value='Detail'>
                                        </form>
                                    </td>
                                </tr>";
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>