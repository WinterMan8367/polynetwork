<?
    session_start();
    $server_path = $_SERVER['DOCUMENT_ROOT'];
    require_once("$server_path/php/regular_functions/functions.php");
    require_once("$server_path/php/regular_functions/db_model.php");

    if (!empty($_SESSION))
    {
        header("Location: /profile/");
        exit;
    }
    else
    {
        if (!empty($_POST['login']) and !empty($_POST['password']))
        {
            $login = $_POST['login'];
            $password = $_POST['password'];
    
            $arr = authorization($login, $password);
            if (!empty($arr))
            {
                $_SESSION['user_info'] = getAllUserInfo($arr['password_hash']);
                $id = $_SESSION['user_info']['id'];
                header("Location: /profile/?id=$id");
                exit;
            }
            else
            {
                view_notification('incorrect');
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Вход</title>
        <link rel="shortcut icon" href="/image/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="/styles/variable.css">
        <link rel="stylesheet" href="/styles/reset.css">
        <link rel="stylesheet" href="/login/styles/styles.css">
    </head>
    <body>
        <div id="login-block">
            <img id="full-logo" src="/image/full_logo.png" alt="Логотип СПТ">
            <p class="welcome">Вход в Полисеть</p>
            <form action="" method="POST">
                <input name="login" placeholder="Номер телефона, почта или UID" required>
                <input name="password" type="password" placeholder="Пароль" required>
                <div class="save-data">
                    <input id="save-data-checkbox" type="checkbox" name="save-data">
                    <label for="save-data-checkbox">
                        Сохранить вход
                    </label>
                    <span>?</span>
                    <div class="save-data-note">
                        <p class="p-head">
                            Сохранить ввод
                        </p>
                        <p>
                            Позволяет сохранить данные аккаунта для быстрого входа с этого устройства
                        </p>
                    </div>
                </div>
                <input type="submit" value="Войти">
            </form>
            <a class="forgot-password" href="/forgot-password/index.html">
                Забыли пароль?
            </a>
        </div>
        <div id="rgstr-block">
            <p>
                Ещё нет учётной записи? 
            </p>
            <a href="/registration/index.php" class="rgstr-btn">Зарегистрироваться</a>
            <p>
                После регистрации вы получите доступ ко всем возможностям Полисети.
            </p>
        </div>
        <div id="copyright">
            <p>
                Черных Игорь, 2ПР-21 © 2023
            </p>
        </div>
    </body>
</html>