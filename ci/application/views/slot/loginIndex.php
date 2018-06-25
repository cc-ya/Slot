<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="utf-8">
    <title>CodeIgniterSlot</title>
</head>
<body>
<div>
    <h1>ログイン</h1>
    <?php if(!empty($error_message)) echo $error_message; ?>
    <form method="post" accept-charset="utf-8" action="http://localhost/slot/ci/index.php/Login/loginIndex/">
    <input type="text" name="name" value="" placeholder="ユーザー名を入力">
        <br>
        <input type="password" name="pass" value="" placeholder="パスワードを入力">
        <br>
        <input type='hidden' name='access' value='true'>
        <input type="submit" name="login" value="ログイン">
    </form>
    <br>
    <h2>↓新規登録はこちら</h2>
    <input type="button" value="新規登録" onClick="location.href='http://localhost/slot/ci/index.php/Login/loginRegistration/'">
</div>
</body>
</html>