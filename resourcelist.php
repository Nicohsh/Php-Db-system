<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Resourcelist</title>
</head>

<body>
<a href="projectlist.php">Projekter</a>
<h1>Resourcelist</h1>

<ul>

<?php
require_once 'dbcon.php';

$sql = 'SELECT r.resource_id, r.r_name FROM resource r';
$stmt = $link->prepare($sql);
$stmt->execute();
$stmt->bind_result($rid, $rnam);

while($stmt->fetch()) {
	echo '<li><a href="resource.php?rid='.$rid.'">'.$rnam.'</a></li>'.PHP_EOL;
}


?>
</ul>

<h2>Tilføj ny resource</h2>

<form method="post">
<p>Navn</p>
<input type="text" name="r_name">
<p>Beskrivelse</p>
<input type="text" name="r_dt">
<p>Job</p>
<select name="rtc">
<?php
require_once 'dbcon.php';

$sql = 'SELECT *
FROM type_code';
$stmt = $link->prepare($sql);
$stmt->execute();
$stmt->bind_result($rtc, $rtnam);

while($stmt->fetch()) {
	echo '<option value="'.$rtc.'">'.$rtnam.'</option>'.PHP_EOL;
}
?>
 
</select>
<input type="submit" name="add" >
</form>

<?php
$rnam = filter_input(INPUT_POST, 'r_name');
$rdt = filter_input(INPUT_POST, 'r_dt');
$rtc = filter_input(INPUT_POST, 'rtc');
if (isset($_POST['add'])) {
$sql = 'INSERT INTO resource
VALUES (null, ?, ?, ?)';
$stmt = $link->prepare($sql);
$stmt->bind_param('ssi', $rnam, $rdt, $rtc);
$stmt->execute();
}
?>

</body>
</html>