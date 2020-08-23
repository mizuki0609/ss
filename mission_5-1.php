<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_5-1</title>
    </head>
    <body>
        <form action="" method="post">
            【　投稿フォーム　】<br>
            <input type="str" name="name" placeholder="Name"><br>
            <input type="str" name="comment" placeholder="Comment">
            <input type="password" name="pass1" placeholder="Password">
            <button type="submit" name="flag" value=1>投稿</button><br><br>
            
            【　削除フォーム　】<br>
            <input type="number" name="dstep" placeholder="Delete Number">
            <input type="password" name="pass2" placeholder="Password">
            <button type="submit" name="dflag" value=1>削除</button><br><br>
            
            【　編集フォーム　】<br>
            <input type="number" name="estep" placeholder="Edit Number"><br>
            <input type="str" name="ename" placeholder="Name"><br>
            <input type="str" name="ecomment" placeholder="Comment">
            <input type="password" name="pass3" placeholder="Password">
            <button type="submit" name="eflag" value=1>編集</button><br>
            
        </form>
    <?php
     //「パスワードが空欄でなければ投稿ver.」
     //フロー
     //DB接続設定
     //１　データベース接続
     //２　テーブル作成
     //３　代入
     //４　削除＆メッセージ表示
     //５　編集＆メッセージ表示
     //６　新規投稿＆メッセージ表示
     //７　表示
     
         //１　データベース接続
         $dsn = 'mysql:dbname=データベース名;host=localhost'; //$dsnの中にはスペースを入れない。
             $user = 'ユーザー名';
             $password = 'パスワード';
             $pdo = new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
         
         //２　テーブル作成
           //sql：データベースと会話するための言語
           //stmt：プリペアードステートメント　実行後にsqlの実行結果に関する情報を得たい時
           //pdo(PHP Data Object)：新しいデータベース抽象化のためのクラス
           //query：データベースに対する命令文・問い合わせ
             $sql = "CREATE TABLE IF NOT EXISTS mission51"
             ."("
             ."id INT AUTO_INCREMENT PRIMARY KEY,"
             ."name char(32),"
             ."comment TEXT,"
             ."submitDate datetime,"
             ."password char(15)"
             .");";
             $stmt = $pdo -> query($sql);
         
         //３　代入
         //データ関係
         $name = $_POST["name"];
         $submitDate = date("Y/m/d H:i:s");
         $password = "W77QU8Rt4w";
         //新規投稿関係
         $comment = $_POST["comment"];
         $pass = $_POST["pass1"];
         $flag = $_POST["flag"];
         //削除関係
         $dstep = $_POST["dstep"];
         $dpass = $_POST["pass2"];
         $dflag = $_POST["dflag"];
         //編集関係
         $estep = $_POST["estep"];
         $ename = $_POST["ename"];
         $ecomment = $_POST["ecomment"];
         $epass = $_POST["pass3"];
         $eflag = $_POST["eflag"];
         //メッセージ関係
         $message = "";
         echo "_____________________________________________" . "<br><br>";
         
         
         //４　削除＆メッセージ表示
         if($dflag == 1){
             if(!empty($dstep && $dpass)){
                 $sql = $pdo -> prepare("DELETE FROM mission51 WHERE id =:id");
                 $sql -> bindParam(':id',$dstep);
                 $sql -> execute();
                 $message = " No." . "$dstep" . " 削除成功！！";
             }else{  //ERROR表示ZONE
                 if(empty($dstep)){
                     $message = "Error: Delete number is empty!";
                 }if(empty($dpass)){
                     $message = "Error: Delete password is empty!";
                 }
             }
             
             
         //５　編集＆メッセージ表示
         }elseif($eflag == 1){
             if(!empty($ename && $ecomment && $epass)){
                 $id = $estep; //編集する投稿番号
                 $sql = 'UPDATE mission51 SET name=:name,comment=:comment WHERE id=:id';
                 $sql = $pdo -> prepare($sql);
                 $sql -> bindParam(':name',$ename,PDO::PARAM_STR);
                 $sql -> bindParam(':comment',$ecomment,PDO::PARAM_STR);
                 $sql -> bindParam(':id',$estep);
                 $sql -> execute();
                 $message = "編集成功！！";
             }else{
                 if(empty($ename)){
                     $message = "Error: Edit name is empty!";
                 }if(empty($ecomment)){
                     $message = "Error: Edit comment is empty!";
                 }if(empty($epass)){
                     $message = "Error: Edit password is empty!";
                 }if(empty($estep)){
                     $message = "Error: Edit ID is empty!";
                 }
             }    
                 
         //６　新規投稿＆メッセージ表示
         }elseif($flag == 1){
             if(!empty($name && $comment && $pass)){
                 $sql = $pdo -> prepare("INSERT INTO mission51 (name,comment,submitDate)VALUES(:name,:comment,:submitDate)");
                 $sql -> bindParam(':name',$name,PDO::PARAM_STR);
                 $sql -> bindParam(':comment',$comment,PDO::PARAM_STR);
                 $sql -> bindParam(':submitDate',$submitDate);
                 $sql -> execute();
                 $message = "投稿成功！！";
             }else{
                 if(empty($name)){
                     $message = "Error: Post name is empty!";
                 }if(empty($comment)){
                     $message = "Error: Post comment is empty!";
                 }if(empty($pass)){
                     $message = "Error: Post password is empty!";
                 }
                 
             }
         }
         
         //７　表示
         echo "$message" . "<br>";
         echo "<br>" . "_____________________________________________" . "<br>" . "【　投稿一覧　】" . "<br>";
         $sql = 'SELECT*FROM mission51';
         $stmt = $pdo -> query($sql);
         $results = $stmt -> fetchAll();
             foreach($results as $row){
                 echo $row['id'].',';
                 echo $row['name'].',';
                 echo $row['comment'].',';
                 echo $row['submitDate'].'<br>';
             echo "<hr>";
             }
         
        
    ?>
     </body>
</html>
