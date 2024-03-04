<? 
    session_start();
    if ($_SESSION['user_info']['role_name'] != 'admin')
    {
        header("Location: login/index.php");
        exit;
    }
    else
    {
        echo <<<HTML
            <!DOCTYPE html>
            <html lang="ru">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Index</title>
                    <link rel="shortcut icon" href="/image/favicon.ico" type="image/x-icon">
                </head>
                <body>
                    <h1>Панель администратора</h1>
                    <a href="/php/regular_functions/test.php">Перейти на тестовую страницу</a>
                    <br>
                    <a href="/profile/">Перейти в профиль</a>
                </body>
            </html>
        HTML;
    }
?>