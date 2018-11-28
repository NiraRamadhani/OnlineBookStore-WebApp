<?php
    
    $username = $_COOKIE['username'];
    $access_token = $_COOKIE['access_token'];
    $id = $_COOKIE['id'];

    if (!isset($username) or !isset($access_token) or !isset($id)) {
        // check if variables not null, if null redirect to login
        header('Location: login.php');
    } elseif ($id == $access_token.$username) {
        // check if id = access_token + username
        // true: do task
        // false: redirect to login
        if (isset($_POST['bookid'])) {
            $bookid = $_POST['bookid'];            
        } else {
            $bookid = $_GET['bookid'];
        }
    } else {
        header('Location: login.php');  
    }
  
?>

<!DOCTYPE html>
    <html>
        <head>
            <title>Book-Detail</title>
            <link rel="stylesheet" type="text/css" href="public/css/body.css">   
            <link rel="stylesheet" type="text/css" href="public/css/navbar.css">   
            <link rel="stylesheet" type="text/css" href="public/css/order.css">
        </head>
        <body>
            <div id="nav">
                <ul>
                    <li id="li-pro-book"><a href="search.php" id="pro-book">
                        <span class="text-yellow">Pro</span><span class="text-white">-Book</span>
                    </a></li>
                    <li id="li-username"><a href="profile.php" id="username" class="text-white">Hi, <?php echo $_COOKIE['username']; ?></a></li>
                    <li id="li-logout"><a href="logout.php" id="logout" class="text-white">
                        <img src="public/img/power.png" alt="Logout" height="30" width="30">
                    </a></li>
                </ul>
                <ul id="menu">
                    <li><a class="active text-white" href="search.php">Browse</a></li>
                    <li><a class="text-white" href="history.php">History</a></li>
                    <li><a class="text-white" href="profile.php">Profile</a></li>
                </ul>
            </div>

            <div class="order">
                <?php

                    $con = mysqli_connect("localhost","root","","probooks");

                    if (mysqli_connect_errno()) {
                        echo "Failed to connect to MySQL: " . mysqli_connect_error();
                    };

                    $sql_book = "SELECT title, author, description, image FROM book WHERE id = \"$bookid\"; ";
                    $res_book = mysqli_query($con, $sql_book);
                    $row_book = mysqli_fetch_assoc($res_book);
                    
                    $sql_review = " SELECT bookid, content, round(rating, 1) as rating, username, image FROM (ordering JOIN review ON (ordering.id = orderid)) JOIN user USING (username) WHERE bookid = \"$bookid\" ORDER BY review.id DESC; ";
                    $res_review = mysqli_query($con, $sql_review);

                    $sql_rating = "SELECT coalesce(round(avg(rating),1), 0) as rate FROM review JOIN ordering ON (ordering.id = orderid) WHERE bookid = \"$bookid\"; ";
                    $res_rating = mysqli_query($con, $sql_rating);
                    $row_rating = mysqli_fetch_assoc($res_rating);

                    $star_yellow = "star-active.png";
                    $star_black = "star-inactive.png";

                    $qry_num_transaction = "SELECT MAX(ID) as id FROM ordering;";
                    $result = mysqli_fetch_assoc(mysqli_query($con, $qry_num_transaction));
                    $num = $result['id'] + 1;

                    function insertOrder($conn, $username, $bookid, $cnt) {
                        $date = getdate();
                        $tgl = "{$date["year"]}-{$date["mon"]}-{$date["mday"]}";

                        $sql = "INSERT INTO ordering (username, bookid, count, `date`) VALUES ('$username', \"$bookid\", '$cnt', '$tgl');";
                        echo $bookid."<br>";
                        echo "$sql";
                        
                        $res = mysqli_query($conn, $sql);
                        if ($res) {
                            echo "success";
                        } else {
                            echo "error".mysql_error();
                        }
                    }

                    if (isset($con, $username, $bookid, $_POST['selected'])) {
                        insertOrder($con, $username, $bookid, $_POST['selected']);
                    }

                    echo "
                        <table class='desc-book'>
                        <tr>
                            <td>
                                <h2 class='text-orange'>{$row_book['title']}</h2>
                                <div class='author'>{$row_book['author']}</div>
                                <div class='desc'>{$row_book['description']}</div>
                            </td>
                            <td class='picture'>
                                <img src='{$row_book['image']}' class='img-right'>
                                <br>
                    ";

                    for ($x = 0; $x < floor($row_rating['rate']); $x++) {
                        echo "<img src='public/img/{$star_yellow}' class='star'>";
                    }

                    for ($x = floor($row_rating['rate']); $x < 5; $x++) {
                        echo "<img src='public/img/{$star_black}' class='star'>";
                    }

                    echo "   
                                <br>
                                <center><b>{$row_rating['rate']} / 5.0</b></center>
                            </td>
                        </tr>
                        </table>
                    ";

                    echo "
                        <h3>Order</h3>
                        Jumlah: 
                        <select id='dropdown'>
                            <option value='1'>1</a>
                            <option value='2'>2</a>
                            <option value='3'>3</a>
                            <option value='4'>4</a>
                            <option value='5'>5</a>
                        </select>
                        <br>
                        <button id='myBtn' type='button' onclick='{order($bookid)}'>Order</button>
                        <br>
                        <div id='MyBtn'>
                            <div id='myModal' class='modal'>
                                <div class='modal-content'>
                                    <span class='close'>&times;</span>
                                    <br>
                                    <p class='modal-text'>
                                        <img src='public/img/tick.png' class='img-tick'>
                                        <b>Pemesanan Berhasil!<br></b>
                                        Nomor Transaksi : {$num}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        
                    ";
                    
                ?>
                <h3>Reviews</h3>
                <?php
                    while ($row_review = mysqli_fetch_assoc($res_review)) {
                        echo "
                            <table>
                            <tr>
                                <td>
                                    <img src={$row_review['image']} class='img-left'>
                                </td>
                                <td class='desc-review'>
                                    <div class='uname'>@{$row_review['username']}</div>
                                    <div class='rev'>{$row_review['content']}</div>
                                </td>
                                <td class='user-rating'>
                                    <img src='public/img/star-active.png' class='star-one'>
                                    <center><b>" . number_format($row_review['rating'], 1). " / 5.0</b></center>
                                </td>
                            </tr>
                            </table>
                        ";
                    }
                ?>
                <script>

                    function order(id) {
                        
                        if (!xmlhttp) {
                            var xmlhttp = new XMLHttpRequest();
                        }
                        var e = document.getElementById("dropdown");
                        var selected = encodeURIComponent(e.options[e.selectedIndex].value);

                        var url="order.php";
                        var param = "selected=" + selected +"&bookid=" + id;
                        xmlhttp.open("POST", url, true);

                        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xmlhttp.setRequestHeader("Content-length", param.length);
                        xmlhttp.setRequestHeader("Connection", "close");

                        xmlhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                // alert(xmlhttp.responseText);
                                var modal = document.getElementById("myModal");
                                var btn = document.getElementById("MyBtn");
                                var span = document.getElementsByClassName("close")[0];
                                modal.style.display = "block";
                                                            
                                span.onclick = function() {
                                    modal.style.display = "none";
                                }
                                window.onclick = function(event) {
                                    if (event.target == modal) {
                                        modal.style.display = "none";
                                    }
                                }
                            }
                        }
                        xmlhttp.send(param)
                    }
                </script>
            </div>
        </body>
    </html>