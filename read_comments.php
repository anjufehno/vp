<?php
require_once "../config.php";
$conn = new mysqli($server_host, $server_user_name, $server_password, $database);
$conn->set_charset("utf8");
$stmt = $conn->prepare("SELECT comment, grade, added FROM vp_daycomment");
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
<head>
<a href="bänner"><img src="pics/888.jpg" alt="bänner"></a>
    <meta charset="utf-8">
    <title>Liza Kruglova programmerib veebi</title>
</head>
<body>
<h1>Liza Kruglova programmerib veebi</h1>
<p>See leht on loodud õppetöö raames ja ei sisalda tõsiseltvõetavat sisu!</p>
<p>Õppetöö toimus <a href="https://www.tlu.ee" target="_blank">Tallina Ülikoolis</a></p>
<?php echo $comment_html; ?>
<body>
</html>