<?
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
	require_once('db_model.php');
    require_once('functions.php');
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Test PHP</title>
        <link rel="shortcut icon" href="/image/favicon.ico" type="image/x-icon">
	</head>
	<body>
        <a href="/">Перейти в Панель администратора</a>
        <center>
            <h1>Тест функций</h1>
        </center>
        <br>
		<?
            echo $_SERVER['DOCUMENT_ROOT'];
            echo "<br>";
            $cyrillic = array('а', 'б', 'в', 'г', 'д', 'е',
            'ё', 'ж', 'з', 'и', 'й', 'к',
            'л', 'м', 'н', 'о', 'п', 'р',
            'с', 'т', 'у', 'ф', 'х', 'ц',
            'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
            $latin = array('q', 'w', 'e', 'r', 't', 'y',
            'u', 'i', 'o', 'p', 'a', 's',
            'd', 'f', 'g', 'h', 'j', 'k',
            'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm');
            $word = "sSdasdasds-mailru";
            echo $word, "<br>";
            if (preg_check($word, "email") != 1)
            {
                echo "Соответствует почте.";
            }
            else
            {
                echo "Не соответствует почте.";
            }
            echo "<br>";
        ?>
            <br>
            <br>
            <center>
                <h1>Тест кода</h1>
            </center>
            <br>
        <?
            var_export($cyrillic);
        ?>
	</body>
</html>