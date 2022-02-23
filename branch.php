<?php

if(isset($_POST['edit']) == true)
{
	$id = $_POST['edit'];
	$id = htmlspecialchars($id,ENT_QUOTES,'UTF-8');
	header('Location: edit.php?edit='.$id);
	exit();
}
if(isset($_POST['delete']) == true)
{
	$id = $_POST['delete'];
	$id = htmlspecialchars($id,ENT_QUOTES,'UTF-8');
	header('Location: delete.php?delete='.$id);
	exit();
}

?>