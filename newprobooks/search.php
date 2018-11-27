<!DOCTYPE html>
<html ng-app="probookApp">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Page Title</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
  <link rel="stylesheet" type="text/css" href="public/css/navbar.css">
  <link rel="stylesheet" type="text/css" href="public/css/body.css">
  <link rel="stylesheet" type="text/css" href="public/css/search-books.css">
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.5/angular.min.js"></script>
  <script src="main.js"></script>
</head>
<body>
  <!-- NAVBAR -->
    <div id="nav">
        <ul>
            <li id="li-pro-book"><a href="search-books.php" id="pro-book">
                <span class="text-yellow">Pro</span><span class="text-white">-Book</span>
            </a></li>
            <li id="li-username"><a href="profile.php" id="username" class="text-white">Hi, </a></li>
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
  <!-- CONTENT -->
    <div class="content" ng-controller="ProbookController as probook">
        <div class="container text-align-left">
            <h2 class="text-orange">Search Book</h2>
        </div>
        <div class="container text-align-left">
            <form name="search" ng-submit="probook.search()">
                <input type="text" ng-model="probook.searchTerm" id="search-box" class="input" size="30" placeholder="Search your book here">
                <input type="submit" value="Search" class="input text-white" id="submit-button">
            </form>
        
            <div>
              <div ng-repeat="book in probook.books">
                <div class="container text-align-left">
                  <h1 class="text-orange">Search Result</h1>
                </div>

                <tr>
                    <td class='picture vertical-align-top'>
                        <img class='img-book' ng-src= "{{book.gambar}}">
                    </td>
                    <td class='book-data text-align-right vertical-align-top'>
                        <p class='title-book text-orange'>{{book.judul}}</p>
                        <p class='author-book'>{{book.penulis}}- {{book.rating}}/5.0 ({{book.votesCount}} votes)</p>
                        <p class='desc-book'>{{book.sinopsis}}</p>
                    </td>
                </tr>
                <tr class='button-detail text-align-right'>
                    <td colspan='2'>
                        <form method='get' action='order.php'>
                            <input type='hidden' id='book-id' name='bookid' value={{book.id}}>
                            <input class='submit-button text-white' type='submit' value='Detail'>
                        </form>
                    </td>
                </tr>

              </div>
            </div>            
        </div>
    </div>  
</body>
</html>