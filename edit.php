<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit ToDo Page</title>
</head>
<body>

<?php

try
{
    $id = $_GET['edit'];
    $id = htmlspecialchars($id,ENT_QUOTES,'UTF-8');

    $dsn ='mysql:dbname=todo;host=localhost;charset=utf8';
    $user ='root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT title,content,updated_at FROM mst_todo WHERE id=?';
    $stmt = $dbh->prepare($sql);
    $data[] = $id;
    $stmt->execute($data);
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $title = $rec['title'];
    $contents = $rec['content'];
    $title = htmlspecialchars($title,ENT_QUOTES,'UTF-8');
    $contents = htmlspecialchars($contents,ENT_QUOTES,'UTF-8');

    $dbh= null;
}
catch (Exception $e)
{
	echo 'ただいま障害により大変ご迷惑をおかけしております。';
	exit();
}

?>

<h1>
    Edit ToDo Page
</h1>
<form method="post" action="edit_check.php">
    <div style="margin: 10px">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
    </div>
    <div style="margin: 10px">
        <label for="title">タイトル：</label>
        <input type="text" name="title" value="<?php echo $title; ?>">
    </div>
    <div style="margin: 10px">
        <label for="content">内容：</label>
        <textarea name="contents" rows="8" cols="40"><?php echo $contents; ?></textarea>
    </div>
    <br />
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="確認">
</form>

</body>
</html>