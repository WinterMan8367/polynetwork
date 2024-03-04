<?
    session_start();
    $server_path = $_SERVER['DOCUMENT_ROOT'];
    require_once("$server_path/php/regular_functions/functions.php");
    require_once("$server_path/php/regular_functions/db_model.php");
    
    if (empty($_SESSION))
    {
        if (!empty($_POST))
        {
            $firstname = $_POST['firstname'];
            $name = $_POST['name'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];
            $repeat_password = $_POST['repeat_password'];
            $sex = $_POST['sex'];
    
            if (!empty($firstname) and !empty($name) and !empty($email) and !empty($phone) and !empty($password) and !empty($repeat_password) and !empty($sex))
            {
                $result = registration($firstname, $name, $lastname, $email, $phone, $password, $repeat_password, $sex);
        
                if ($result == 'access')
                {
                    header('Location: /login');
                    exit;
                }
                else
                {
                    view_notification($result);
                }
            }
            else
            {
                view_notification('required');
            }
        }
    }
    else
    {
        header("Location: /profile/");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Регистрация</title>
        <link rel="shortcut icon" href="/image/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="/styles/variable.css">
        <link rel="stylesheet" href="/styles/reset.css">
        <link rel="stylesheet" href="/registration/styles/styles.css">
    </head>
    <body>
        <div id="rgstr-block">
            <img id="full-logo" src="/image/full_logo.png" alt="Логотип СПТ">
            <p class="rgstr-head">Регистрация в Полисети</p>
            <form action="" method="POST">
                <div>
                    <input name="firstname" placeholder="Фамилия" value='<? if (!empty($_POST)) echo $firstname ?>' required>
                    <input name="name" placeholder="Имя" value='<? if (!empty($_POST)) echo $name ?>' required>
                </div>
                <input name="lastname" placeholder="Отчество (если есть)" value='<? if (!empty($_POST)) echo $lastname ?>'>
                <div>
                    <input name="email" type="email" placeholder="Почта" value='<? if (!empty($_POST)) echo $email ?>' required>
                    <input name="phone" type="tel" placeholder="Номер телефона" value='<? if (!empty($_POST)) echo $phone ?>' required>
                </div>
                <div>
                    <input name="password" type="password" placeholder="Пароль" required>
                    <input name="repeat_password" type="password" placeholder="Повторите пароль" required>
                </div>
                <div class="sex">
                    <p>
                        Ваш пол:
                    </p>
                    <div>
                        <div class="input-sex">
                            <input name="sex" type="radio" value="1" checked>
                            <p>Мужской</p>
                        </div>
                        <div class="input-sex">
                            <input name="sex" type="radio" value="0">
                            <p>Женский</p>
                        </div>
                    </div>
                </div>
                <input type="submit" value="Зарегистрироваться">
            </form>
        </div>
        <div id="login-block">
            <p>
                Уже есть учётная запись? 
            </p>
            <a href="/login/" class="login-btn">Войти</a>
            <p>
                Если вы являетесь студентом СПТ, то у вас уже есть учётная запись по универсальному ID.
            </p>
        </div>
        <div id="copyright">
            <p>
                Черных Игорь, 2ПР-21 © 2023
            </p>
        </div>
    </body>
</html>