<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Page</title>
</head>
<body>

<h1>
    Create ToDo Page
</h1>
<form method="post" action="create_check.php">
    <div style="margin: 10px">
        <label for="title">タイトル：</label>
        <input type="text" name="title">
    </div>
    <div style="margin: 10px">
        <label for="content">内容：</label>
        <textarea name="contents" rows="8" cols="40"></textarea>
    </div>
    <br />
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="確認">
</form>

</body>
</html>