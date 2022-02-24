<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search Result Page</title>
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

    $search = $_GET['search']; //検索ワード 
    $like_search = "%".$search."%";

    if($search != null)
    {
        //ヒット数カウント
        $result = $dbh->prepare("SELECT * FROM mst_todo WHERE title LIKE (:search)");
        $result->bindValue(":search", $like_search, PDO::PARAM_STR);
        $result->execute();
        $rec = $result->fetchAll(PDO::FETCH_ASSOC);
        $resultNum = $result->rowCount();

        //現在ページ番号取得
        define('max_view', 5);
        if(!isset($_GET['page_no']))
        { 
            $nowPage = 1;            
        }
        else
        {
            $nowPage = $_GET['page_no'];
        }

        //ページ数計算
        $totalPage = ceil($resultNum / max_view);    //celi:切り上げ

        //前へ・次への処理
        $prev = max($nowPage - 1, 1);
        $next = min($nowPage + 1, $totalPage);

        //検索結果取得
        $stmt = $dbh->prepare("SELECT * FROM mst_todo WHERE title LIKE (:search) LIMIT :start,:max");
        
        if ($nowPage == 1)
        {
            $stmt->bindValue(":search", $like_search, PDO::PARAM_STR);
            $stmt->bindValue(":start", $nowPage -1, PDO::PARAM_INT);
            $stmt->bindValue(":max", max_view,PDO::PARAM_INT);
        }
        else 
        {
            $stmt->bindValue(":search",$like_search,PDO::PARAM_STR);
            $stmt->bindValue(":start",($nowPage -1 ) * max_view,PDO::PARAM_INT);
            $stmt->bindValue(":max",max_view,PDO::PARAM_INT);
        }        
        
        $stmt->execute();
        $rec2 = $stmt->fetchAll(PDO::FETCH_ASSOC); 

        $dbh= null;

        echo '<h1>Search Result Page</h1>';
    
        /*検索結果表示*/
        echo '検索ワード：', $search;
        echo '<br />';
        echo 'ヒット件数：', $resultNum;
        echo '<br /><br />';
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
                foreach($rec2 as $rec2)
                {
	                if($rec2 == false)
	                {
		                break;
	                }
                    echo '<tr>';
                        echo '<td>', $rec2['id'], '</td>';
                        echo '<td>', $rec2['title'], '</td>';
                        echo '<td>', $rec2['content'], '</td>';
                        echo '<td>', $rec2['created_at'], '</td>';
                        echo '<td>', $rec2['updated_at'], '</td>';
                        echo '<td><button type="submit" name="edit" value="'.$rec2['id'].'" style="padding: 10px;font-size: 16px;">編集する</button></td>';
                        echo '<td><button type="submit" name="delete" value="'.$rec2['id'].'" style="padding: 10px;font-size: 16px;">削除する</button></td>';
                    echo '</tr>';
                }
            echo '</form>';
        echo '</table>';
        //ページ番号
        if ($nowPage > 1)
        {
            echo "<a href='./search_result2.php?page_no=$prev&search=$search' style='padding: 5px'>前へ</a>";
        }
        else
        {
            echo "<span style='padding: 5px;'> </span>";
        }
    
        for ($n = 1; $n <= $totalPage; $n ++)
        {
            if ($n == $nowPage)
            {
                echo "<span style='padding: 5px;'>$nowPage</span>";
            }
            else
            {
                echo "<a href='./search_result2.php?page_no=$n&search=$search' style='padding: 5px;'>$n</a>";
            }
        }   

        if ($nowPage < $totalPage)
        {
            echo "<a href='./search_result2.php?page_no=$next&search=$search' style='padding: 5px;'>次へ</a>";
        }
        else
        {
            echo "<span style='padding: 5px;'> </span>";
        }

        echo '<br />';
        echo "<a href='./index.php' style='padding: 5px;'>ToDo一覧</a>";
    }
    else
    {
        echo '検索ワードを入力してください';
        echo '<br /><br />';
        echo "<a href='./index.php' style='padding: 5px;'>ToDo一覧</a>";

        $dbh= null;
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
