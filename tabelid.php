<?php
require_once "../../config.php";
$conn = new mysqli($server_host, $server_user_name, $server_password, $database);
$conn->set_charset("utf8");
$stmt = $conn->prepare("SELECT comment, grade, added FROM film");
echo $conn->error;
$stmt->bind_result($comment_from_db, $grade_from_db, $added_from_db);
$stmt->execute();
$comment_html = null;
while($stmt->fetch()){
	//echo $comment_from_db;
	$comment_html .= "<p>" .$comment_from_db .", hinne päevale: " .$grade_from_db;
	$comment_html .= ", lisatud " .$added_from_db .".</p> \n";
	
}
?>
<!DOCTYPE html>
<html lang="et">
<title>Andmetabel</title>
</head>
<body>
<h1>Andmetabel</h1>
<p>Siin lehes on Eesti filmide andmetabel:</p>
<h3>Kevade</h3>
<ul>
	<li>Valmimisaasta: 1969</li>
	<li>Kestus: 84 minutit</li>
	<li>Žanr: komöödia, draama</li>
	<li>Tootja: TallinnFilm</li>
	<li>Lavastaja: Arvo Kruusement</li>
</ul>
<body>
</html>

