<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Client</title>
</head>

<body>
<?php $cid = filter_input(INPUT_GET, 'cid', FILTER_VALIDATE_INT) or die('Missing/illegal parameter');

require_once 'dbcon.php';
$sql = 'SELECT c.name, c.address, z.zip, z.city, c.contact_name, c.contact_phone, p.name, p.project_id
FROM project p, client c, zip z
WHERE c.client_id = ?
AND c.client_id = p.client_client_id
AND c.zip_zip = z.zip';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $cid);
$stmt->execute();
$stmt->bind_result($cnam, $cadd, $zzip, $zcity, $ccn, $ccp, $pnam, $pid);
?>

<ul>
<?php
while($stmt->fetch()) { 
echo '<h1>Kundenavn: '.$cnam.'</h1>';
echo '<li>Kundeadresse: '.$cadd.'</li>';
echo '<li>Portnr.: '.$zzip.'</li>';
echo '<li>By: '.$zcity.'</li>';
echo '<li>Kunde-kontaktperson: '.$ccn.'</li>';
echo '<li>Kunde-kontaktnummer: '.$ccp.'</li>';
echo '<li><a href="http://localhost/client/project.php?pid='.$pid.'">Projektnavn: '.$pnam.'</a></li>';

}
?>
</ul>
</body>
</html>