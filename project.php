<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Project</title>
</head>

<body>
<a href="projectlist.php">Tilbage til projektliste</a>
<?php
$pid = filter_input(INPUT_GET, 'pid', FILTER_VALIDATE_INT) or die('Missing/illegal parameter');

require_once 'dbcon.php';
$sql = 'SELECT p.name, p.description, p.start_date, p.end_date, c.Client_id, c.name 
FROM project p, client c
WHERE p.project_id = ?
AND c.client_id=p.client_client_id';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $pid);
$stmt->execute();
$stmt->bind_result($pnam, $pdesc, $pstart, $pend, $cid, $cnam);
?>


<ul>
<?php
while($stmt->fetch()) { 
echo '<h1>Projektnavn: '.$pnam.'</h1>';
echo '<li>Projektbeskrivelse: '.$pdesc.'</li>';
echo '<li>Projekt startdato: '.$pstart.'</li>';
echo '<li>Projekt slutdate: '.$pend.'</li>';
echo '<li>Kundenummer: '.$cid.'</li>';
echo '<li><a href="client.php?cid='.$cid.'">Kundenavn: '.$cnam.'</a></li>';
}
?>
</ul>

<?php
$sql = 'SELECT r.r_name, r.resource_id, t.r_type_name
FROM resource r, project p, resource_has_project rp, type_code t
WHERE p.project_id = ?
AND p.project_id = rp.project_project_id
AND r.resource_id = rp.resource_resource_id
AND r.type_code_r_type_code = t.r_type_code';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $pid);
$stmt->execute();
$stmt->bind_result($rnam, $rid, $rtn);
?>



<ul>
<h1>Resourcer</h1>
<?php
while($stmt->fetch()) { 

echo '<li><a href="resource.php?rid='.$rid.'">Resourcenavn: '.$rnam.'</a></li>';
echo '<li>Job: '.$rtn.'</li>';
echo '<li>Resourcenummer: '.$rid.'</li>';
}
?>
</ul>

<hr>

<h1>Add Resource to Project</h1>
<form method="post">
	<select name="rid">
    <?php
$sql = 'SELECT resource_id, r_name, t.r_type_name
FROM resource, type_code t
WHERE r_type_code = type_code_r_type_code';
$stmt = $link->prepare($sql);
$stmt->execute();
$stmt->bind_result($rid, $rnam, $tynam);
while ($stmt->fetch()) {
	echo '<option value='.$rid.'">'.$rnam.' ('.$tynam.')</option>'.PHP_EOL;
}
?>
	<h2>Start Dato</h2>
	<input type="date" name="start">
    <h2>Slut Dato</h2>
    <input type="date" name="end">
    <h2>Hourly Usage Rate</h2>
    <input type="number" name="hur">
    <input type="submit" name="add">
</form>

<?php
$rstart = filter_input(INPUT_POST, 'start');
$rend = filter_input(INPUT_POST, 'end');
$hur = filter_input(INPUT_POST, 'hur');
$rid = filter_input(INPUT_POST, 'rid');
if (isset($_POST['add'])) {
$sql = 'INSERT INTO resource_has_project
VALUES (?, ?, ?, ?, ?)';
$stmt = $link->prepare($sql);
$stmt->bind_param('iissi', $rid, $pid, $rstart, $rend, $hur);
$stmt->execute();
}
?>

  <h2>Slet en ressource fra et dette projekt</h2>  
  
<form method="post">
	<select name="rnam">
    <?php
$sql = 'SELECT resource_id, r_name, t.r_type_name
FROM resource, type_code t
WHERE r_type_code = type_code_r_type_code';
$stmt = $link->prepare($sql);
$stmt->execute();
$stmt->bind_result($rid, $rnam, $tynam);
while ($stmt->fetch()) {
	echo '<option value='.$rid.'">'.$rnam.' ('.$tynam.')</option>'.PHP_EOL;
}
?>
    <input type="submit" name="delres" value="Slet">
</form>


<?php
$rid = filter_input(INPUT_POST, 'rnam');
if (isset($_POST['delres'])) {
$sql = 'DELETE FROM resource_has_project WHERE resource_resource_id = ?';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $rid);
$stmt->execute();
header ('refresh:0');
}
?>

  <h2>Opdater projektbeskrivelsen til dette projekt</h2> 

<br>
<form method="post">
<input type="text" name="pdesc">
<input type="submit" name="submit" value="Update!">
</form>

<?php
if (isset($_POST['submit'])){
$pdesc = filter_input(INPUT_POST, 'pdesc');
$sql = 'UPDATE project p
SET p.description = ?
WHERE project_id = ?';
$stmt = $link->prepare($sql);
$stmt->bind_param('si', $pdesc, $pid);
$stmt->execute();
header ('refresh:0');
}
?>

</body>
</html>