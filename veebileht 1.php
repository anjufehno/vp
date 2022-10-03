<?php
require_once "../../config.php";
echo $server_host;
$author_name = "Jelizvata Kruglova";
$full_time_now = date("d.m.Y.H:i:s");
$weekday_now = date("N");
//echo $weekday_now;
$weekdaynames_et = ["esmaspäev","teisipäev","kolmapäev","neljapäev","reede","lauapäev","pühapäev"];
$hours_now = date("H");
//echo $hours_now;
$part_of_day = "suvaline päeva osa";
$say_et=["porgand","kurk","tomat","õun","apelsiin"];
if($weekday_now <=5){
    if($hours_now < 7 or $hours_now >= 23){$part_of_day = "uneaeg!";}
	if($hours_now >= 7 and $hours_now < 8){$part_of_day = "hommik";}
	if($hours_now >= 8 and $hours_now < 18){$part_of_day = "koolipäev";}
if($hours_now >= 18 and $hours_now < 23){$part_of_day = "õhtu";}}
	if($weekdaynames_et ==6){$part_of_day = "nädalavahetus";}
	if($weekdaynames_et ==7){$part_of_day = "nädalavahetus";}
	
//uurime semestri kestmist
	$semester_begin = new DateTime("2022-9-5");
	$semester_end = new DateTime ("2022-12-18");
	$semester_duration = $semester_begin->diff($semester_end);
	$semester_duration_days = $semester_duration->format("%r%a");
	$from_semester_begin = $semester_begin->diff(new DateTime("now"));
	$from_semester_begin_days = $from_semester_begin->format("%r%a");
	
	//juhuslik arv
	//küsin massiivi pikkust
	//echo count($weekdaynames_et);
	//echo mt_rand(0, count($weekdaynames_et) -1);
	
	
	//juhuslik photo
	$photo_dir="photos";
	//loen kataloogi sisu
	$all_files= scandir($photo_dir);
	//var_dump($all_files);
	$all_files = array_slice(scandir($photo_dir), 2);
	//kontrollin, kas ikka foto
	$allowed_photo_types = ["image/jpeg", "image/png"];
	//tsükkel
	//Muutuja väärtuse suurendamine $muutuja = $muutuja + 5
	// $muutuja +=5
	//kui vaja liita 1
	//$muutuja ++
	//sama moodi $muutuja -=  $muutuja --
	/*for($i = 0;$i < count($all_files); $i ++ ){
		echo $all_files [$i];
	}*/
	$photo_files = [];
	foreach($all_files as $filename){
		//echo $filename;
		$file_info = getimagesize($photo_dir ."/" .$filename);
		//var_dump($file_info);
		//kas on lubatud tüüpide nimekirjas
		if(isset($file_info["mime"])){
		if(in_array($file_info["mime"], $allowed_photo_types)){
			array_push($photo_files, $filename);
		}
		}
	}
		
	
	//var_dump($all_files);
	//vaatame, mida vormis sisestati
	//var_dump($_POST);
	//echo $_POST["todays_adjective_input"];
	$todays_adjective="pole midagi sisestatud";
	if(isset($_POST["todays_adjective_input"]) and !empty($_POST["todays_adjective_input"])){
		$todays_adjective = $_POST["todays_adjective_input"];
	}
	//loome rippmenüü valikud
	//<option value="0">tln_1.JPG/</option>
    //<option value="1">tln_4.JPG/</option>
	$select_html = '<option value="0" selected disabled>Vali pilt</option>';
	for($i = 0;$i < count($photo_files); $i ++ ){
	$select_html .='<option value="' .$i .'">';
    $select_html .=	$photo_files[$i];
	$select_html .="</options>";
	}
	// <img src="kataloog/fail" alt="tekst">
	$photo_html = '<img src="' .$photo_dir ."/" .$all_files[mt_rand(0, count($all_files) -1)] .'"';
	$photo_html .= ' alt="Tallinna pilt">';
	$comment_error = null;
	if(isset($_POST["comment_submit"])){
		if(isset($_POST["comment_input"]) and !empty($_POST["comment_input"])){
			$comment= ["comment_input"];
	}   else{
	$comment_error = "Komentaar jäi kirjutamata";
}
	$grade = $_POST["grade_input"];
	if(empty($comment_error)){
		
		

	//if(isset($_POST["photo_select"]) and !empty($_POST["photo_select"]>=0)){
	//echo "Valiti photo nr:" .$_POST["photo_select"];
	
	//if(isset($_POST["comment_submit"])){
	$comment = $_POST["comment_input"];
    $grade = $_POST["grade_input"];
	$conn = new mysqli($server_host, $server_user_name, $server_password, $database);
	$conn->set_charset("utf8");
	$stmt = $conn->prepare("INSERT INTO vp_daycomment (comment, grade) values (?,?)");
	echo $conn->error;
	$stmt->bind_param("si", $comment, $grade);
	$stmt->execute();
	$stmt->close();
	$conn->close();
	}
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
<p>Lehe avamise hetk: <?php echo $weekdaynames_et [$weekday_now-1] .", " .$full_time_now;?></p>
<p>Praegu on <?php echo $part_of_day;?>.</p>
<?php echo $say_et[mt_rand(0, count($say_et)-1)];?>
<p>Semestri pikkus on <?php echo $semester_duration_days;?> päeva. See on kestnud juba <?php echo $from_semester_begin_days; ?> päeva.</p>
<a href="grusha"><img src="pics/grusha.jfif" alt= "Grusha"></a>
<p>Не путю, ведь я люблю свою лучшую подругу.</p>
<form method="POST">
    <label for="comment_input">Kommentaar tänase päeva kohta (140 tähte)</label>
	<br>
	<textarea id="comment_input" name="comment_input" cols="35" rows="4"
	placeholder="kommentaar"></textarea>
	<br>
	<label for="grade_input">Hinne tänase päevale (0-10)</label>
	<input type="number" id="grade_input"" name="grade_input" min="0" max="10" step="1"
	value="7">
	<input type="submit" id="comment_submit"" name="comment_submit" value="Salvesta">
	<span><?php echo $comment_error; ?></span>
</form> 
<form method="post">
 <input type="text" id="todays_adjective_input" name="todays_adjective_input"
 placeholder="Kirjuta siia omadusõna tänase päeva kohta">
 <input type="submit" id="todays_adjective_submit" name="todays_adjective_submit" value="Saada omadussõna">
 </form>
 <p>Omadusõna tänase kohta: <?php echo $todays_adjective; ?></p>
<hr>
<form method="POST">
<select id="photo_select" name="photo_select">
<?php echo $select_html;?>

</select>
<input type="submit" id="photo_submit" name="photo_submit" value="Määra photo">
</form>
<?php
  if(isset($_POST["photo_select"]) and ($_POST["photo_select"] >=0))
  {
	$photo_html ='<img src="' .$photo_dir ."/" . $photo_files[$_POST["photo_select"]]. '"alt="Tallinna pilt">';
	echo $photo_html;
  }
  else
  {
   echo $photo_html;
  }
?>

<hr>

</body>
</html>