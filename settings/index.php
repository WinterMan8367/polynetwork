<?
    session_start();

    $server_path = $_SERVER['DOCUMENT_ROOT'];
    require_once("$server_path/php/regular_functions/functions.php");
    require_once("$server_path/php/regular_functions/db_model.php");

    if (empty($_SESSION))
    {
        header("Location: /login");
        exit;
    }

    if (empty($_GET))
    {
        header("Location: ?category=main");
        exit;
    }

    if (!empty($_POST))
    {
        if ($_GET['category'] == "main")
        {
            if (empty($_POST['avatar_file']))
            {
                $_POST['avatar_file'] = "none";
            }

            $result = update_user_main($_SESSION['user_info']['id'], $_POST['firstname'], $_POST['name'], $_POST['lastname'], $_POST['date_of_birth'], $_POST['city'], $_POST['status'], $_POST['avatar_file'], $_POST['sex'], $_POST['about_me']);
            unset($_POST);
            header("Refresh: 0");
            exit;
        }
        elseif ($_GET['category'] == "privacy")
        {
            $result = update_user_privacy($_SESSION['user_info']['id'], $_POST['hide_lastname'], $_POST['hide_email'], $_POST['hide_phone'], $_POST['hide_date_of_birth'], $_POST['type_of_profile']);
            unset($_POST);
            header("Refresh: 0");
            exit;
        }
    }

    $category = $_GET['category'];

    $user_info = getAllUserInfo($_SESSION['user_info']['id']);

    $id = $user_info['id'];
    $login = $user_info['login'];
    $email = $user_info['email'];
    $phone = $user_info['phone'];
    $firstname = $user_info['firstname'];
    $name = $user_info['name'];
    $lastname = $user_info['lastname'];
    $sex = $user_info['sex'];
    $status = $user_info['status'];
    $date_of_birth = $user_info['date_of_birth'];
    $city = $user_info['city'];
    $about_me = $user_info['about_me'];
    $hide_lastname = $user_info['hide_lastname'];
    $hide_email = $user_info['hide_email'];
    $hide_phone = $user_info['hide_phone'];
    $hide_date_of_birth = $user_info['hide_date_of_birth'];
    $type_of_profile = $user_info['type_of_profile'];
    $avatar_file = $user_info['avatar_file'];

    switch ($user_info['status_name'])
    {
        case "Не указан":
            $status_name = 0;
            break;
        case "Студент СПТ":
            $status_name = 1;
            break;
        case "Выпускник СПТ":
            $status_name = 2;
            break;
        case "Абитуриент":
            $status_name = 3;
            break;
        case "Студент":
            $status_name = 4;
            break;
        case "Выпускник":
            $status_name = 5;
            break;
        case "Преподаватель СПТ":
            $status_name = 7;
            break;
        case "Преподаватель":
            $status_name = 8;
            break;
    }

    switch ($user_info['role_name'])
    {
        case "default":
            $role_name = "Пользователь";
            break;
        case "admin":
            $role_name = "Администратор";
            break;
        case "teacher":
            $role_name = "Преподаватель";
    }
?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Настройки</title>
        <link rel="shortcut icon" href="/image/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="/styles/variable.css">
        <link rel="stylesheet" href="/styles/reset.css">
        <link rel="stylesheet" href="/settings/styles/styles.css">
	</head>
	<body>
        <!-- Шапка сайта. -->
        <? require_once("$server_path/php/header.php") ?>
        <!-- Конец шапки. -->

        <!-- Тело сайта. -->
        <main>
            <!-- Модальные окна. -->
            <!-- Затемнение фона. -->
            <div id="dark-for-modal"></div>
            <!-- Удаление аккаунта. -->
            <div class="delete-profile-btn" style="display: none">
                <p>
                    Вы действительно хотите удалить свой профиль?
                </p>
                <div>
                    <form action="" method="GET">
                        <button type="submit" name="delete" value="1" id="delete-profile-yes">
                            Да
                        </button>
                        <button type="button" id="delete-profile-no">
                            Нет
                        </button>
                    </form>
                </div>
            </div>
            <!-- Подтверждение сохранения. -->
            <div class="confirm-btn" style="display: none">
                <p>
                    Помните, что, меняя настройки, помимо одного или нескольких изменённых полей сохраняются и ВСЕ остальные! Редактируйте их c осторожностью.
                    <br>
                    <br>
                    Вы уверены, что хотите сохранить настройки?
                </p>
                <div>
                    <button form="form" type="submit" id="confirm-yes">
                        Да
                    </button>
                    <button type="button" id="confirm-no">
                        Нет
                    </button>
                </div>
            </div>
            <!-- Конец модальных окон. -->
            <div class="main-block container">
                <div class="header">
                    <div class="head">
                        <div class="head-in-head">
                            <p>
                                Настройки
                            </p>
                        </div>
                        <div class="category-links">
                            <a href="?category=main" class="category-menu<?=$category == "main" ? " active-link" : ""?>">
                                Основные настройки
                            </a>
                            <a href="?category=privacy" class="category-menu<?=$category == "privacy" ? " active-link" : ""?>">
                                Приватность
                            </a>
                            <a href="?category=security" class="category-menu<?=$category == "security" ? " active-link" : ""?>">
                                Безопасность
                            </a>
                        </div>
                    </div>
                </div>
                <div class="settings">
                    <? if ($category == "main"): ?>
                    <!-- Основные настройки: смена ФИО, статуса, даты рождения, города и т.д. -->
                    <form action="" method="POST" id="form">
                        <div class="form-block">
                            <p class="subtitle">Смена фамилии, имени и отчества</p>
                            <div class="multiple-input">
                                <input type="text" name="firstname" placeholder="Введите фамилию" value="<?=$firstname?>">
                                <input type="text" name="name" placeholder="Введите имя" value="<?=$name?>">
                                <input type="text" name="lastname" placeholder="Введите отчество"<?= !empty($lastname) ? "value='$lastname'" : "" ?>>
                            </div>
                        </div>
                        <hr class="line">
                        <div class="form-block center">
                            <p class="subtitle">Смена дня рождения</p>
                            <input type="date" name="date_of_birth"<?= !empty($date_of_birth) ? "value='$date_of_birth'" : "" ?>>
                        </div>
                        <hr class="line">
                        <div class="form-block center">
                            <p class="subtitle">Смена города</p>
                            <div class="one-input">
                                <input type="text" name="city" placeholder="Введите ваш город"<?= !empty($city) ? "value='$city'" : "" ?>>
                            </div>
                        </div>
                        <hr class="line">
                        <? if ($user_info['group_name'] == 'none'): ?>
                        <div class="form-block center">
                            <p class="subtitle">Смена статуса обучения</p>
                            <div class="one-input">
                                <select name="learning_status">
                                    <option value="0"<?= $user_info['status_name'] == "Не указан" ? " selected" : ""?>>Не указан</option>
                                    <option value="3"<?= $user_info['status_name'] == "Абитуриент" ? " selected" : ""?>>Абитуриент</option>
                                    <option value="4"<?= $user_info['status_name'] == "Студент" ? " selected" : ""?>>Студент</option>
                                    <option value="5"<?= $user_info['status_name'] == "Выпускник" ? " selected" : ""?>>Выпускник</option>
                                </select>
                            </div>
                        </div>
                        <hr class="line">
                        <? endif ?>
                        <div class="form-block">
                            <p class="subtitle">Ваш статус</p>
                            <div class="with-description">
                                <textarea name="status" placeholder="Введите ваш статус под именем"><?= !empty($status) ? "$status" : "" ?></textarea>
                                <p>0/60 символов</p>
                            </div>
                        </div>
                        <hr class="line">
                        <div class="form-block center">
                            <p class="subtitle">Ваш аватар</p>
                            <input id="load-file-input" name="avatar" type="file" style="display: none">
                            <label for="load-file-input">
                                <div class="filename">Файл не выбран</div>
                                <div class="input-btn">Выбрать</div>
                            </label>
                        </div>
                        <hr class="line">
                        <div class="form-block">
                            <p class="subtitle">Ваш пол</p>
                            <div class="multiple-input">
                                <div class="radio">
                                    <input type="radio" name="sex" value="1"<?= $sex == 1 ? " checked" : ""?>>
                                    <p>Мужской</p>
                                </div>
                                <div class="radio">
                                    <input type="radio" name="sex" value="0"<?= $sex == 0 ? " checked" : ""?>>
                                    <p>Женский</p>
                                </div>
                            </div>
                        </div>
                        <hr class="line">
                        <div class="form-block">
                            <p class="subtitle">О себе</p>
                            <div class="with-description">
                                <textarea name="about_me" placeholder="Расскажите о себе"><?= !empty($about_me) ? "$about_me" : "" ?></textarea>
                                <p>0/1024 символов</p>
                            </div>
                        </div>
                        <hr class="line">
                        <div class="submit-block">
                            <button type="button" id="confirm">Сохранить</button>
                        </div>
                    </form>
                    <? elseif ($category == "privacy"): ?>
                    <!-- Настройки приватности: скрытие даты рождения, контактных данных и т.д. -->
                    <form action="" method="POST" id="form">
                        <div class="form-block">
                            <p class="subtitle">Скрыть отчество в профиле?</p>
                            <div class="multiple-input">
                                <div class="radio">
                                    <input type="radio" name="hide_lastname" value="1"<?= $hide_lastname == 1 ? " checked" : ""?>>
                                    <p>Да</p>
                                </div>
                                <div class="radio">
                                    <input type="radio" name="hide_lastname" value="0"<?= $hide_lastname == 0 ? " checked" : ""?>>
                                    <p>Нет</p>
                                </div>
                            </div>
                        </div>
                        <hr class="line">
                        <div class="form-block">
                            <p class="subtitle">Скрыть электронную почту в профиле?</p>
                            <div class="multiple-input">
                                <div class="radio">
                                    <input type="radio" name="hide_email" value="1"<?= $hide_email == 1 ? " checked" : ""?>>
                                    <p>Да</p>
                                </div>
                                <div class="radio">
                                    <input type="radio" name="hide_email" value="0"<?= $hide_email == 0 ? " checked" : ""?>>
                                    <p>Нет</p>
                                </div>
                            </div>
                        </div>
                        <hr class="line">
                        <div class="form-block">
                            <p class="subtitle">Скрыть номер телефона в профиле?</p>
                            <div class="multiple-input">
                                <div class="radio">
                                    <input type="radio" name="hide_phone" value="1"<?= $hide_phone == 1 ? " checked" : ""?>>
                                    <p>Да</p>
                                </div>
                                <div class="radio">
                                    <input type="radio" name="hide_phone" value="0"<?= $hide_phone == 0 ? " checked" : ""?>>
                                    <p>Нет</p>
                                </div>
                            </div>
                        </div>
                        <hr class="line">
                        <div class="form-block">
                            <p class="subtitle">Скрыть дату рождения в профиле?</p>
                            <div class="multiple-input">
                                <div class="radio">
                                    <input type="radio" name="hide_date_of_birth" value="1"<?= $hide_date_of_birth == 1 ? " checked" : ""?>>
                                    <p>Да</p>
                                </div>
                                <div class="radio">
                                    <input type="radio" name="hide_date_of_birth" value="0"<?= $hide_date_of_birth == 0 ? " checked" : ""?>>
                                    <p>Нет</p>
                                </div>
                            </div>
                        </div>
                        <hr class="line">
                        <div class="form-block">
                            <p class="subtitle">Тип профиля</p>
                            <div class="multiple-input">
                                <div class="radio">
                                    <input type="radio" name="type_of_profile" value="0"<?= $type_of_profile == 0 ? " checked" : ""?>>
                                    <p>Открытый</p>
                                </div>
                                <div class="radio">
                                    <input type="radio" name="type_of_profile" value="1"<?= $type_of_profile == 1 ? " checked" : ""?>>
                                    <p>Закрытый</p>
                                </div>
                            </div>
                        </div>
                        <hr class="line">
                        <div class="submit-block">
                            <button type="button" id="confirm">Сохранить</button>
                        </div>
                    </form>
                    <? elseif ($category == "security"): ?>
                    <!-- Настройки безопасности: смена пароля, почты, логина и т.д. -->
                    <form action="" method="POST" id="form">
                        <div class="form-block center">
                            <p class="subtitle">Смена логина (UID) для входа</p>
                            <div class="one-input">
                                <input type="text" name="login" class="input-text" placeholder="Введите ваш логин"<?= !empty($login) ? "value='$login'" : "" ?>>
                            </div>
                        </div>
                        <hr class="line">
                        <div class="form-block center">
                            <p class="subtitle">Смена электронной почты для входа</p>
                            <div class="one-input">
                                <input type="email" name="email" class="input-text" placeholder="Введите вашу электронную почту"<?= !empty($email) ? "value='$email'" : "" ?>>
                            </div>
                        </div>
                        <hr class="line">
                        <div class="form-block center">
                            <p class="subtitle">Смена номера телефона для входа</p>
                            <div class="one-input">
                                <input type="tel" name="phone" class="input-text" placeholder="Введите ваш номер телефона"<?= !empty($phone) ? "value='$phone'" : "" ?>>
                            </div>
                        </div>
                        <hr class="line">
                        <div class="form-block">
                            <p class="subtitle">Смена пароля для входа</p>
                            <div class="multiple-input">
                                <input type="password" name="old_password" class="input-text" placeholder="Введите текущий пароль">
                                <input type="password" name="new_password" class="input-text" placeholder="Введите новый пароль">
                                <input type="password" name="repeat_new_password" class="input-text" placeholder="Повторите пароль">
                            </div>
                        </div>
                        <hr class="line">
                        <div class="info-block">
                            <p class="subtitle">Ваш статус</p>
                            <p class="role"><?=$role_name?></p>
                        </div>
                        <hr class="line">
                        <p class="delete-profile">
                            Также вы можете <button type="button" class="delete">удалить свой профиль</button>
                        </p>
                        <hr class="line">
                        <div class="submit-block">
                            <button type="button" id="confirm">Сохранить</button>
                        </div>
                    </form>
                    <? endif ?>
                </div>
            </div>
        </main>
        <!-- Конец тела сайта. -->
        <script src="/scripts/script.js"></script>
        <script>
            if ($('button.delete') != null)
            {
                $('button.delete').addEventListener('click', () => {
                    $('div.delete-profile-btn').removeAttribute('style');
                    $('div#dark-for-modal').style.visibility = "visible";
                })
            }

            $('button#delete-profile-no').addEventListener('click', () => {
                $('div.delete-profile-btn').style.display = "none";
                $('div#dark-for-modal').style.visibility = "hidden";
            })

            $('button#confirm').addEventListener('click', () => {
                $('div.confirm-btn').removeAttribute('style');
                $('div#dark-for-modal').style.visibility = "visible";
            })

            $('button#confirm-no').addEventListener('click', () => {
                $('div.confirm-btn').style.display = "none";
                $('div#dark-for-modal').style.visibility = "hidden";
            })
        </script>
        <script>
            let fields = document.querySelectorAll('#load-file-input');
            Array.prototype.forEach.call(fields, function (input) {
            let label = input.nextElementSibling,
                labelVal = label.querySelector('.filename').innerText;
        
            input.addEventListener('change', function (e) {
                let countFiles = '';
                if (this.files && this.files.length >= 1)
                    countFiles = this.files.length;
        
                if (countFiles)
                    label.querySelector('.filename').innerText = document.getElementById('load-file-input').files.item(0).name;
                else
                label.querySelector('.filename').innerText = 'Файл не выбран';
            });
            });
        </script>
    </body>
</html>