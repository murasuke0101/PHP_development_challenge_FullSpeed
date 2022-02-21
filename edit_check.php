<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Edit Check Page</title>
</head>
<body>

<?php
$id = $_POST['id'];
$title = $_POST['title'];
$contents = $_POST['contents'];
//$created_at = date('Y/m/d H:i:s');

$title = htmlspecialchars($title,ENT_QUOTES,'UTF-8');
$contents = htmlspecialchars($contents,ENT_QUOTES,'UTF-8');
//$created_at = htmlspecialchars($created_at,ENT_QUOTES,'UTF-8');

if($title == '')
{
	print 'タイトルを入力してください<br />';
}
else
{
	print 'タイトル：';
	print $title;
	print '<br />';
}

if($contents == '')
{
	print '内容を入力してください<br />';
}
else
{
	echo '内容：';
	echo $contents;
	echo '<br /><br />';

}

if($title == '' || $contents == '')
{
	print '<form>';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '</form>';
}
else
{
	echo '<form method="post" action="edit_done.php">';
	echo '<input type="hidden" name="title" value="'.$title.'">';
	echo '<input type="hidden" name="id" value="'.$id.'">';
	/*echo '<div style="margin: 10px">';
	echo '<label for="content">内容：</label>';
	echo '<textarea name="contents" rows="8" cols="40"></textarea>';
	echo '</div>';*/
	echo '<input type="hidden" name="contents" value="'.$contents.'">';
	//echo '<input type="hidden" name="created_at" value="'.$created_at.'">';
	echo '<br />';
	echo '<input type="button" onclick="history.back()" value="戻る">';
	echo '<input type="submit" value="投稿する">';
	echo '</form>';
}

?>

</body>
</html>