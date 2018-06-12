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
    <h1>スロットゲーム</h1>
    <?php echo $name. ":". $coin; ?>
    <table border=1>
    <?php foreach($reel_all as $posi_array):?>
        <td><?php foreach($posi_array as $key => $value): ?>
            <?php echo $value; ?>
            <br>
            <?php if($key == Slot::POSITION_LOWER) break;?>
        <?php endforeach; ?></td>
    <?php endforeach; ?>
    </table>
    <input type="button" accesskey="A" value="まわす！" onClick="location.href='http://localhost/ci/index.php/Slot/main/'">
    <br>
    <?php
    if(isset($result)) {
        foreach ($result as $key => $value):
            echo !empty($display)? $display[$key].':' : 'スタート';
            echo !empty($value)? "あたり!" : "--------" ;
            echo "<br />";
        endforeach;
    }?>
    <br>
    履歴<br>
    <?php
    if(isset($record)) {
        foreach($record as $value) {
            echo $value;
            echo "<br/>";
        }
    }
    ?>
</div>
<input type="button" value="TOPへ戻る" onClick="location.href='http://localhost/ci/index.php/Login/loginIndex/'">
</body>
</html>