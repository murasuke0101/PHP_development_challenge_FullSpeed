<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Index Page</title>
</head>
<body>
<?php
try
{   
    define('max_view', 5);
    $dsn ='mysql:dbname=todo;host=localhost;charset=utf8';
    $user ='root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $count = $dbh->prepare('SELECT COUNT(*) AS count FROM mst_todo');
    $count->execute();
    $total_count = $count->fetch(PDO::FETCH_ASSOC);     /*$total_countに$countの値を格納*/
    $pages = ceil($total_count['count'] / max_view);    /*celi:切り上げ*/ 

    /*ページ番号を取得 */
    if(!isset($_GET['page_no']))
    { 
        $now = 1;
    }
    else
    {
        $now = $_GET['page_no'];
    }

    $select = $dbh->prepare("SELECT id,title,content,created_at,updated_at FROM mst_todo ORDER BY id ASC LIMIT :start,:max ");
                                                                                                           
    if ($now == 1)
    {
        $select->bindValue(":start",$now -1,PDO::PARAM_INT);
        $select->bindValue(":max",max_view,PDO::PARAM_INT);
    }
    else 
    {
        $select->bindValue(":start",($now -1 ) * max_view,PDO::PARAM_INT);
        $select->bindValue(":max",max_view,PDO::PARAM_INT);
    }
    $select->execute();
    $rec = $select->fetchAll(PDO::FETCH_ASSOC);
    $dbh= null;
    /*
    $data = $select->fetchAll(PDO::FETCH_ASSOC);
    $sql = 'SELECT id,title,content,created_at,updated_at FROM mst_todo WHERE 1';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $dbh= null;
    */

    /*ToDoリストを表示*/
    echo '<h1>ToDo List Page</h1>';
    echo '<form action="create.php"><button type="submit" style="padding: 10px;font-size: 16px;margin-bottom: 10px">New Todo</button></form>';
    echo '<table border="1">';
        echo '<colgroup span="5"></colgroup>';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>タイトル</th>';
        echo '<th>内容</th>';
        echo '<th>作成日時</th>';
        echo '<th>更新日時</th>';
        echo '<th>編集</th>';
        echo '<th>削除</th>';
        echo '</tr>';
        echo '<form method="post" action="branch.php">';
        
        foreach($rec as $data)
        {
	        if($rec == false)
	        {
		        break;
	        }
            echo '<tr>';
                echo '<td>', $data['id'], '</td>';
                echo '<td>', $data['title'], '</td>';
                echo '<td>', $data['content'], '</td>';
                echo '<td>', $data['created_at'], '</td>';
                echo '<td>', $data['updated_at'], '</td>';
                echo '<td><button type="submit" name="edit" value="'.$data['id'].'" style="padding: 10px;font-size: 16px;">編集する</button></td>';
                echo '<td><button type="submit" name="delete" value="'.$data['id'].'" style="padding: 10px;font-size: 16px;">削除する</button></td>';
            echo '</tr>';
        }
        echo '</form>';
    echo '</table>';

    /*ページ番号を表示 */
    for ($n = 1; $n <= $pages; $n ++){
        if ($n == $now){
            echo "<span style='padding: 5px;'>$now</span>";
        }else{
            echo "<a href='./index.php?page_no=$n' style='padding: 5px;'>$n</a>";
        }
    }
}
catch (Exception $e)
{
	print 'ただいま障害により大変ご迷惑をおかけしております。';
	exit();
}
?>
</body>
</html>