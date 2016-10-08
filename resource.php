<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
<a href="resourcelist.php">Tilbage til resourcer</a>
<?php
$rid = filter_input(INPUT_GET, 'rid', FILTER_VALIDATE_INT) or die('Missing/illegal parameter');

require_once 'dbcon.php';
$sql = 'SELECT r.r_name, r.resource_detail, t.r_type_name
FROM resource r, type_code t
WHERE r.resource_id = ?
AND R_type_code = type_code_r_type_code';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $rid);
$stmt->execute();
$stmt->bind_result($rnam, $rdt, $rtype);
?>

<h1>Resource</h1>
<ul>
<?php
while($stmt->fetch()) { 
echo '<li>Resourcenavn: '.$rnam.'</li>';
echo '<li>Resourcedetaljer: '.$rdt.'</li>';
echo '<li>Resourcetype: '.$rtype.'</li>';
}
?>
</ul>

<?php
$sql = 'SELECT p.name, p.project_id
FROM project p, resource_has_project rp, resource r
WHERE resource_id = ?
AND p.project_id = rp.project_project_id
AND r.resource_id = rp.resource_resource_id';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $rid);
$stmt->execute();
$stmt->bind_result($pnam, $pid);

?>
<h2>Tilknyttede projekter</h2>
<ul>
<?php
while($stmt->fetch()) { 
echo '<li>Projektnavn: '.$pnam.'</li>';
echo '<li>Projektnummer: '.$pid.'</li>';
}
?>
</ul>



</body>
</html>