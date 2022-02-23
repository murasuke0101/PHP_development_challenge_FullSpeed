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
	$title = $_POST['title'];
	$contents = $_POST['contents'];

	$title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
	$contents = htmlspecialchars($contents, ENT_QUOTES, 'UTF-8');

	$dsn = 'mysql:dbname=todo;host=localhost;charset=utf8';
	$user = 'root';
	$password ='';
	$dbh = new PDO($dsn, $user, $password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = 'INSERT INTO mst_todo(title,content,created_at,updated_at) VALUES (?,?,CURRENT_TIME,CURRENT_TIME)';
	$stmt = $dbh->prepare($sql);
	$data[] = $title;
	$data[] = $contents;
	$stmt->execute($data);
	$dbh = null;

	echo $title;
	echo 'を追加しました。<br />';

}
catch (Exception $e)
{
	echo 'ただいま故障により大変ご迷惑をおかけしております。';
	exit();
}
?>

<a href="index.php">戻る</a>

</body>
</html>