<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Create Done Page</title>
</head>
<body>

<?php

try
{
	
	$id = $_POST['id'];
	$title = $_POST['title'];
	$contents = $_POST['contents'];

	$title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
	$contents = htmlspecialchars($contents, ENT_QUOTES, 'UTF-8');

	$dsn = 'mysql:dbname=todo;host=localhost;charset=utf8';
	$user = 'root';
	$password = '';
	$dbh = new PDO($dsn, $user, $password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = 'UPDATE mst_todo SET title=?, content=?, updated_at=CURRENT_TIME WHERE id=?';
	$stmt = $dbh->prepare($sql);
	$data[] = $title;
	$data[] = $contents;
	$data[] = $id;
	$stmt->execute($data);

	$dbh = null;

	echo $title;
	echo 'を編集しました。<br />';
 
}
catch (Exception $e)
{
	print'ただいま故障により大変ご迷惑をおかけしております。';
	exit();
}

?>

<a href="index.php">戻る</a>

</body>
</html>