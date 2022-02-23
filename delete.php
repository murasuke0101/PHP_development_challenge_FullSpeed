<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Delete Page</title>
</head>
<body>

<?php

try
{

	$id = $_GET['delete'];
	$id = htmlspecialchars($id,ENT_QUOTES,'UTF-8');
	
	$dsn = 'mysql:dbname=todo;host=localhost;charset=utf8';
	$user = 'root';
	$password ='';
	$dbh = new PDO($dsn, $user, $password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = 'DELETE FROM mst_todo WHERE id=?';
	$stmt = $dbh->prepare($sql);
	$rec = $stmt->fetch(PDO::FETCH_ASSOC);
	$data[] = $id;
	$stmt->execute($data);

	$dbh = null;

	echo '削除しました。<br />';
	echo '<br />';
	echo '<a href="index.php">戻る</a>';
}
catch (Exception $e)
{
	print'ただいま故障により大変ご迷惑をおかけしております。';
	exit();
}
?>

</body>
</html>