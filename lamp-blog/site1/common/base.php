<?php
class Base
{
	function __construct()
    {
		ini_set('display_errors', 1);
		error_reporting(E_ALL);
		echo "コンスト";
    }

	public function titleDisplay()
	{
		echo 'aaaa';
	}
}
?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="utf-8">
	<title>タイトル</title>
</head>
<body>
	<h1>ブログタイトル</h1>
</body>
</html>