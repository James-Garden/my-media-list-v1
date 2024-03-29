<?php include 'header.php';?>

<?php
$conn = openconn();

if (!empty($_GET['user_id'])) {
  $uid = $_GET['user_id'];
} elseif (!empty($_SESSION['user_id'])) {
  $uid = $_SESSION['user_id'];
} else {
  header("Location: login.php");
  die();
}

$stmt = "SELECT * FROM user WHERE user_id={$uid}";
$query = $conn->prepare($stmt);
$query->execute();
$result = $query->get_result();
$row = $result->fetch_row();
$username = $row[1];
$avatar = $row[10];

if (empty($row[4])) {
	$last_online = "<p style='margin-left:auto;color:lightGreen;'>Now</p>";
} else {
	$last_date = new DateTime($row[4], new DateTimeZone('Europe/London'));
	$now_date = new DateTime("now", new DateTimeZone('Europe/London'));
	$interval = $last_date->diff($now_date);
	if(!empty($interval->y)){
		if ($interval->y==1){
			$last_online="Last year";
		} else {
			$last_online=$interval->y." years ago";
		}
	} elseif (!empty($interval->m)) {
		if ($interval->m==1){
			$last_online="Last month";
		} else {
			$last_online=$interval->m." months ago";
		}
	} elseif (!empty($interval->d)) {
		if ($interval->d==1){
			$last_online="Yesterday";
		} else {
			$last_online=$interval->d." days ago";
		}
	} elseif (!empty($interval->h)) {
		if ($interval->h==1){
			$last_online="1 hour ago";
		} else {
			$last_online=$interval->h." hours ago";
		}
	} elseif (!empty($interval->i)) {
		if ($interval->i==1){
			$last_online="A minute ago";
		} else {
			$last_online=$interval->i." minutes ago";
		}
	} else {
		$last_online=$interval->s." seconds ago";
	}
	$last_online = "<p style='margin-left:auto;'>{$last_online}</p>";
}

$date = new DateTime($row[3]);
$date_joined = $date->format('M d, Y');


?>

<div class="username">
	<?php echo "<h2>{$username}'s Profile</h2>"; ?>
</div>
<div class="profile-wrapper">
	<div class="profile-left-col">
		<div class="avatar">
			<?php echo "<img src='https://mymedialist.s3.eu-west-2.amazonaws.com/avatars/{$avatar}' id='avatar'>";?>
		</div>
		<div class="user-info">
			<?php
			echo "<div class='info-box'><p>Last Online</p>";
			echo "{$last_online}</div>";
			echo "<div class='info-box'><p>Date Joined</p>";
			echo "<p style='margin-left:auto;'>{$date_joined}</p></div>";
			?>
		</div>
		<div class="user-list-links">
			<button type="button" class="btn btn-dark user-list-links" id="film-list-link"><a title="Go to film list" class="user-list-links"><i class="bi bi-film"></i>&nbsp;Films</a></button>
			<button type="button" class="btn btn-dark user-list-links" id="tv-list-link"><a title="Go to tv list" class="user-list-links"><i class="bi bi-tv"></i>&nbsp;TV</a></button>
			<button type="button" class="btn btn-dark user-list-links" id="book-list-link"><a title="Go to book list" class="user-list-links"><i class="bi bi-book"></i>&nbsp;Books</a></button>
		</div>
	</div>
	<div class="profile-inner-wrapper">
		<div class="profile-mid-col">
			<p>summary section here</p>
		</div>
		<div class="profile-right-col">
			<p>update section here</p>
		</div>
		<div class="profile-favourites">
			<p>favourites section here</p>
		</div>

	</div>
</div>

<?php include 'footer.php';?>
