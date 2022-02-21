<?php

if(isset($_POST['edit']) == true)
{
	$id = $_POST['edit'];
	//header('Location: edit.php.php?edit='.$id);
	header('Location: edit.php?edit='.$id);
	exit();
}
if(isset($_POST['delete']) == true)
{
	$id = $_POST['delete'];
	header('Location: delete.php?delete='.$id);
	exit();
}

?>