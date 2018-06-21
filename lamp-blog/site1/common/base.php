<?php
class Base
{
	function __construct()
    {
		ini_set('display_errors', 1);
		error_reporting(E_ALL);
    }

	public function titleDisplay()
	{
?>
		<!DOCTYPE html>
		<html lang="jp">
		<head>
		    <meta charset="utf-8">
		    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		    <meta http-equiv="X-UA-Compatible" content="ie=edge">
			<title>LAMPブログ</title>
		</head>
		</html>
<?php
	}
	public function headerDisplay()
	{
?>
		<body>
			*********************
			<h1>ブログタイトル</h1>
			<br>
			*********************
		</body>
<?php
	}
}
?>