<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>

<h1>Project List</h1>
<a href="resourcelist.php">Resourceliste</a>
<ul>

<?php
require_once 'dbcon.php';

$sql = 'SELECT p.project_id, p.name FROM project p';
$stmt = $link->prepare($sql);
$stmt->execute();
$stmt->bind_result($pid, $pnam);

while($stmt->fetch()) {
	echo '<li><a href="project.php?pid='.$pid.'">'.$pnam.'</a></li>'.PHP_EOL;
}


?>
</ul>

</body>
</html>