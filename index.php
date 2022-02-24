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
    
    $dsn ='mysql:dbname=todo;host=localhost;charset=utf8';
    $user ='root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //ページ数計算
    define('max_view', 5);
    $count = $dbh->prepare('SELECT COUNT(*) AS count FROM mst_todo');
    $count->execute();
    $totalCount = $count->fetch(PDO::FETCH_ASSOC);
    $totalPage = ceil($totalCount['count'] / max_view);    //celi:切り上げ

    //現在ページ番号取得
    if(!isset($_GET['page_no']))
    { 
        $nowPage = 1;
    }
    else
    {
        $nowPage = $_GET['page_no'];
    }
    
    //前へ・次への処理
    $prev = max($nowPage - 1, 1);
    $next = min($nowPage + 1, $totalPage);

    $nowPage = htmlspecialchars($nowPage,ENT_QUOTES,'UTF-8');
    $prev = htmlspecialchars($prev,ENT_QUOTES,'UTF-8');
    $next = htmlspecialchars($next,ENT_QUOTES,'UTF-8');

    //ToDoリストの情報取得
    $select = $dbh->prepare("SELECT * FROM mst_todo ORDER BY id ASC LIMIT :start,:max");
                          
    //:startと:maxに値を代入	
    if ($nowPage == 1)
    {
        $select->bindValue(":start", $nowPage -1,PDO::PARAM_INT);
        $select->bindValue(":max", max_view,PDO::PARAM_INT);
    }
    else 
    {
        $select->bindValue(":start", ($nowPage -1 ) * max_view,PDO::PARAM_INT);
        $select->bindValue(":max", max_view,PDO::PARAM_INT);
    }

    $select->execute();
    $rec = $select->fetchAll(PDO::FETCH_ASSOC); 

    $dbh= null;

    echo '<h1>ToDo List Page</h1>';
    //新規作成
    echo '<form action="create.php"><button type="submit" style="padding: 10px;font-size: 16px;margin-bottom: 10px">New Todo</button></form>';
    
    //検索機能
    echo '検索';
    echo '<form method="post" action="branch.php">';
        echo '<input type="text" name="search_word" style="font-size: 16px; margin-bottom: 15px">';
        echo ' ';
        echo '<input type="submit" name="search" style="font-size: 16px;margin-bottom: 15px" value="検索">';
    echo '</form>';
    
    //ToDoリスト表示
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
        
            foreach($rec as $rec)
            {
	            if($rec == false)
	            {
		            break;
	            }
                echo '<tr>';
                    echo '<td>', $rec['id'], '</td>';
                    echo '<td>', $rec['title'], '</td>';
                    echo '<td>', $rec['content'], '</td>';
                    echo '<td>', $rec['created_at'], '</td>';
                    echo '<td>', $rec['updated_at'], '</td>';
                    echo '<form method="post" action="branch.php">';
                    echo '<td><button type="submit" name="edit" value="'.$rec['id'].'" style="padding: 10px;font-size: 16px;">編集する</button></td>';
                    echo '<td><button type="submit" name="delete" value="'.$rec['id'].'" style="padding: 10px;font-size: 16px;">削除する</button></td>';
                    echo '</form>';
                echo '</tr>';
            }
    echo '</table>';

    //ページ番号
    if ($nowPage > 1)
    {
        echo "<a href='./index.php?page_no=$prev' style='padding: 5px'>前へ</a>";
    }
    else
    {
        echo "<span style='padding: 5px;'> </span>";
    }
    
    for ($n = 1; $n <= $totalPage; $n ++)
    {
        if ($n == $nowPage){
            echo "<span style='padding: 5px;'>$nowPage</span>";
        }
	else
	{
            echo "<a href='./index.php?page_no=$n' style='padding: 5px;'>$n</a>";
        }
    }

    if ($nowPage < $totalPage)
    {
        echo "<a href='./index.php?page_no=$next' style='padding: 5px;'>次へ</a>";
    }
    else
    {
        echo "<span style='padding: 5px;'> </span>";
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
