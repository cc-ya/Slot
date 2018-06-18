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
    <?php echo validation_errors(); ?>
    <h1>新規登録</h1>
    <form method="post" accept-charset="utf-8" action="http://localhost/ci/index.php/Login/loginRegistration">
        <input type="text" name="name" value="" placeholder="ユーザー名を入力">
        <br>
        <input type="password" name="pass" value="" placeholder="パスワードを入力">
        <br>
        <input type="submit" name="registration" value="登録">
    </form>
    <input type="button" value="戻る" onClick="location.href='http://localhost/ci/index.php/Login/loginIndex/'">
</div>
</body>
</html>