<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="utf-8">
	<title>CodeIgniterSlot</title>
    <link href="http://localhost/slot/ci/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="slot">
    <h1>SUS</h1>
    <p><?php if(!empty($lack))echo 'コインが足りないよ'; ?></p>
    <p><?php echo $name. ":". $coin; ?></p>
    <div class="reel_alia">
    <table border=1>
    <?php foreach($reel_all as $posi_array):?>
        <td><?php foreach($posi_array as $key => $value): ?>
            <p><?php echo $value; ?></p>
            <br>
            <?php if($key == Slot::POSITION_LOWER) break;?>
        <?php endforeach; ?></td>
    <?php endforeach; ?>
    </table>
    </div>
    <input type="button" accesskey="A" value="まわす！" onClick="location.href='http://localhost/slot/ci/index.php/Slot/main/'">
    <br>
    <p><?php
    if(isset($result)) {
        foreach ($result as $key => $value):
            echo !empty($display)? $display[$key].':' : 'スタート';
            echo !empty($value)? "あたり!" : "--------" ;
            echo "<br />";
        endforeach;
    }?></p>
    <br>
    <p>履歴</p><br>
    <p><?php
    if(isset($record_list)) {
        foreach($record_list as $value) {
            echo $value;
            echo "<br/>";
        }
    }
    ?></p>
</div>
<input type="button" value="TOPへ戻る" onClick="location.href='http://localhost/slot/ci/index.php/Login/loginIndex/'">
</body>
</html>