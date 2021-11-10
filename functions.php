<?php
function checkenv() {
  $whitelist = array('127.0.0.1','::1');
  if(in_array($_SERVER['REMOTE_ADDR'],$whitelist)) { //Checks if user is in development environment
    return true;
  } else {
    return false;
  }
}

require_once 'vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
$s3 = new Aws\S3\S3Client([
  'version' => 'latest',
  'region' => 'eu-west-2'
]);

session_start();

function openconn() {
  if(checkenv()) { //Checks if user is in development environment
    $conn = new mysqli("localhost","root","C1aran!183","mml",3306); //Attempts to connect to MySQL database
  } else {
    $conn = new mysqli("mml.cpzqthyuc4xm.eu-west-2.rds.amazonaws.com","admin","2cqX4g9DYwEzHXzyDdVx","mml",3306); //Attempts to connect to MySQL database
  }
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  return $conn;
}

function isAdmin() {
  $conn = openconn();
  try {

    if (empty($_SESSION['user_id'])){
      throw new Exception("Not signed in!");
    }
    $this_user_id = $_SESSION['user_id'];
    $stmt = "SELECT admin_id FROM admin WHERE admin_id =" . $this_user_id;
    $query = $conn->prepare($stmt);
    $query->execute();
    $query->store_result();
    $query->bind_result($admin_query);
    $query->fetch();
    $result = $admin_query;
    if (empty($result)) {
      throw new Exception("User not authorised!");
    }
  }
  catch(Exception $e) {
    $conn->close();
    return false;
  }
  $conn->close();
  return true;
}

function invoke401() {
  header('HTTP/1.0 401 Unauthorized');
  echo "<h1>Error 401: Access Denied</h1>";
  echo "<div><a href=\"index.php\">Take me back!</a></div>";

  die();
}

function addToListBtn($mediaId) {
  //This function returns the correct button depending on whether a user has an item in their list or not
  //TODO add checks for if already on list
  $btn = "<button type='button' class='btn btn-link addToList' id=m{$mediaId}>Add</button>";
  return $btn;
}

function updateLastOnline($conn,$user_id) {
  //This function sets the last time a user was online to the current time and date
  //UPDATE user SET last_online=now() WHERE user_id=?;
  $query = $conn->prepare("UPDATE user SET last_online=now() WHERE user_id=?");
  $query->bind_param("i",$user_id);
  $query->execute();
}