<?php
require('functions.php');
?>

<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset="UTF-8">
  <title>My Media List</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="/script.js" defer></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="/style.css">
  <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">
  <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
</head>
<body>
<!--This is the side menu-->
  <div class="sidenav" id="sidenav">
    <div class="sidenav-flex">
      <button class="button-close-side-menu">
        <i class="bi bi-x"></i>
      </button><br>
    </div>
    <div class="side-menu-links">
      <button class="button-link">
        <a href="/"><i class="bi bi-house"></i> Home</a>
      </button><br>
      <button class="button-link">
        <a href="#"><i class="bi bi-film"></i> Films</a>
      </button><br>
      <button class="button-link">
        <a href="#"><i class="bi bi-tv"></i> TV</a>
      </button><br>
      <button class="button-link">
        <a href="#"><i class="bi bi-book"></i> Books</a>
      </button><br>
      <?php
      if (isAdmin()) {
        echo "<button class=\"button-link\">";
        echo "<a href=\"add_media.php\"><i class=\"bi bi-briefcase\"></i> Admin Portal</a>";
        echo "</button><br>";
      }
      ?>
    </div>
  </div>
  <!--This is the header-->
  <header>
    <div class="header-wrapper">
      <div class="header-flex-left">
        <button class="button-menu">
          <i class="bi bi-list"></i>
        </button>
      </div>
      <div class="header-flex-logo">
        <a href = "index.php"><button class="button-logo">
          <i class="bi bi-collection"></i>
        </button></a>
      </div>
      <div class="header-flex-right">
        <?php
          if (!empty($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
            echo "<div><a href=\"profile.php\"><button class=\"button-profile\">";
            echo $_SESSION['username'];
            echo "<i class=\"bi bi-person-circle\"></i></button></a></div>";
            echo "<div class=\"logout-dropdown\">"."<button id=\"logout-button\">Log Out</button>"."</div>";
          } else {
            echo "<a href=\"login.php\"><button class=\"button-profile\"><span>";
            echo "Log In";
            echo " </span><i class=\"bi bi-person-circle\"></i></button></a>";
          }
        ?>
        <!--<div class="logout-dropdown">
          <button id="logout-button">Log Out</button>
        </div>-->
        <button class="button-search">
          <i class="bi bi-search"></i>
        </button>
      </div>
    </div>
  </header>
  <!--This is the search bar-->
  <div class="search-bar">
    <div class="search-wrapper">
      <form class="search-form" action="search.php">
        <label for="user-query">
          <i class="bi bi-search"></i>
        </label>
        <input type="search" name="q" placeholder="SEARCH..." class="search-input"><br>
      </form>
    </div>
  </div>

<!--This is the main page content-->
  <main>
