<?
    session_start();

    $server_path = $_SERVER['DOCUMENT_ROOT'];
    require_once("$server_path/php/regular_functions/functions.php");
    require_once("$server_path/php/regular_functions/db_model.php");

    if (!empty($_SESSION))
    {
        update_online($_SESSION['user_info']['id']);
    }

    if (!empty($_GET['id']))
    {
        $id = $_GET['id'];

        if (empty($_GET['category']))
        {
            header("Location: /profile/?id=$id&category=about_me");
            exit;
        }

        $user_info = getAllUserInfo($id);

        if (empty($user_info))
        {
            view_error('profile_not_found');
        }
    }
    else
    {
        if (!empty($_SESSION))
        {
            $id = $_SESSION['user_info']['id'];
            header("Location: /profile/?id=$id");
            exit;
        }
        else
        {
            view_error('profile_not_selected');
        }
    }

    if (!empty($_POST['post_text']))
    {
        create_user_post($_SESSION['user_info']['id'], $_POST['post_text']);
        unset($_POST);
        header("Refresh: 0");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>
            <?
                if (!empty($_SESSION))
                {
                    echo ($_SESSION['user_info']['id'] == $id) ? "Мой профиль" : "$user_info[firstname] $user_info[name]";
                }
                else
                {
                    echo "$user_info[firstname] $user_info[name]";
                }
            ?>
        </title>
        <link rel="shortcut icon" href="/image/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="/styles/variable.css">
        <link rel="stylesheet" href="/styles/reset.css">
        <link rel="stylesheet" href="/profile/styles/styles.css">
	</head>
	<body>

        <!-- Шапка сайта. -->
        <? require_once("$server_path/php/header.php") ?>
        <!-- Конец шапки. -->

        <!-- Тело сайта. -->
        <?
            if (!empty($user_info))
            {
                $firstname = $user_info['firstname'];
                $name = $user_info['name'];
                $lastname = $user_info['lastname'];
                $status = $user_info['status'];
                $email = $user_info['email'];
                $phone = $user_info['phone'];
                $date_of_birth = $user_info['date_of_birth'];
                $sex = $user_info['sex'];
                $last_update = $user_info['last_update'];
                $date_of_registration = $user_info['date_of_registration'];
                $date_of_registration = friendly_date($date_of_registration);
                $about_me = $user_info['about_me'];
                $city = $user_info['city'];
                $status_name = $user_info['status_name'];
                $group_name = $user_info['group_name'];
                $avatar = $user_info['avatar_file'];
                
                if ($user_info['hide_lastname'] == 1)
                {
                    $lastname = "";
                }
            }
        ?>
        <main>
            <!-- Затемнение фона. -->
            <div id="dark-for-modal"></div>
            <!-- Модальные окна. -->
            <div id="modal">
                <div class="head">
                    <p>Написать пост</p>
                    <button id="close-modal">
                        <img src="/image/close.png">
                    </button>
                </div>
                <div class="text-info">
                    <form action="" method="POST" id="post">
                        <textarea name="post_text" placeholder="Напишите сюда свои мысли..."></textarea>
                    </form>
                </div>
                <div class="modal-btn">
                    <button form="post" type="submit">Отправить пост</button>
                </div>
            </div>
            <!-- Конец модальных окон. -->
            <div class="user-block container">
                <div class="user-info">
                    <div class="user-main">
                        <div class="avatar-name-status">
                            <div class="user-avatar">
                                <? if ($avatar == "none") $avatar = "/image/user_icon.png" ?>
                                <div class="avatar-circle" style="background-image: url(<?=$avatar?>)"></div>
                                <? if ((time() - strtotime($last_update)) < 240): ?>
                                <div class="online-circle"></div>
                                <? endif ?>
                            </div>
                            <div>
                                <p class="fullname">
                                    <?="$firstname $name $lastname"?>
                                </p>
                                <?=
                                    !empty($status)
                                    ?
                                        <<<HTML
                                            <p class="user-status">
                                                $status
                                            </p>
                                        HTML
                                    : ""
                                ?>
                            </div>
                        </div>
                        <div class="user-buttons">
                        <?
                            if (!empty($_SESSION))
                            {
                                if ($id != $_SESSION['user_info']['id'])
                                {
                                    echo <<<HTML
                                        <a class="any-button-style" href="/message/?send_message=$id">Написать сообщение</a>
                                        <a class="any-button-style" href="">Добавить в друзья</a>
                                    HTML;
                                }
                                else
                                {
                                    echo <<<HTML
                                        <a class="any-button-style" href="/settings/">Редактировать</a>
                                        <button class="any-button-style" id="write-post">Написать пост</button>
                                    HTML;
                                }
                            }
                            else
                            {
                                echo <<<HTML
                                    <a class="any-button-style" href="/message/?send_message=$id">Написать сообщение</a>
                                    <a class="any-button-style" href="">Добавить в друзья</a>
                                HTML;
                            }
                        ?>
                        </div>
                    </div>
                    <hr class="line">
                    <div class="date">
                        <div class="last-online">
                            <?
                                if ((time() - strtotime($last_update)) < 240)
                                {
                                    echo <<<HTML
                                        <p class="online">Сейчас в сети</p>
                                    HTML;
                                }
                                else
                                {
                                    $last_update = friendly_date($last_update);
                                    echo <<<HTML
                                        <p>Последний визит:</p>
                                        <p>$last_update</p>
                                    HTML;
                                }
                            ?>
                        </div>
                        <div class="date-of-registration">
                            <?
                                $text = ($sex) ? "Зарегистрирован" : "Зарегистрирована";
                            ?>
                            <p><?=$text?></p>
                            <p><?=$date_of_registration?></p>
                        </div>
                    </div>
                    <hr class="line">
                    <div class="user-stat">
                        <a class="stat-link" href="">
                            <p class="stat-count">10000</p>
                            <p class="stat-text">друзей</p>
                        </a>
                        <a class="stat-link" href="/profile/?id=<?=$id?>&category=posts">
                            <?
                                $posts = get_user_posts($id);
                                $count_posts = 0;
                                if (!empty($posts))
                                {
                                    $count_posts = count($posts);
                                }
                            ?>
                            <p class="stat-count"><?=$count_posts?></p>
                            <p class="stat-text">публикаций</p>
                        </a>
                        <a class="stat-link" href="">
                            <p class="stat-count">10000</p>
                            <p class="stat-text">фотографий</p>
                        </a>
                        <a class="stat-link" href="">
                            <p class="stat-count">10000</p>
                            <p class="stat-text">видео</p>
                        </a>
                    </div>
                </div>
                <div class="category-menu"<?= ($_GET['category'] != "about_me") ? "style='border-bottom: 0'" : ""?>>
                    <a class="category<?= ($_GET['category'] == "about_me") ? " active" : "" ?>" href="/profile/?id=<?=$id?>&category=about_me">Обо мне</a>
                    <a class="category<?= ($_GET['category'] == "posts") ? " active" : "" ?>" href="/profile/?id=<?=$id?>&category=posts">Публикации</a>
                    <a class="category<?= ($_GET['category'] == "photos") ? " active" : "" ?>" href="/profile/?id=<?=$id?>&category=photos">Фотографии</a>
                    <a class="category<?= ($_GET['category'] == "videos") ? " active" : "" ?>" href="/profile/?id=<?=$id?>&category=videos">Видео</a>
                    <a class="category<?= ($_GET['category'] == "groups") ? " active" : "" ?>" href="/profile/?id=<?=$id?>&category=groups">Группы</a>
                </div>
                <? if ($_GET['category'] == "about_me"): ?>
                <div data-user-info="about-me">
                    <p>
                        Обо мне
                    </p>
                    <div class="info-block">
                        <div class="about-me">
                            <?=
                                !empty($about_me)
                                ? $about_me
                                : "Пользователь не указал информации о себе."
                            ?>
                        </div>
                    </div>
                    <hr class="line">
                    <p>
                        Личная информация
                    </p>
                    <div class="info-block">
                        <table>
                            <tr>
                                <? if ($user_info['hide_date_of_birth'] == 0): ?>
                                <td class="paragraph">
                                    Дата рождения:
                                </td>
                                <td class="meaning">
                                    <?=
                                        !empty($date_of_birth)
                                        ? friendly_date($date_of_birth)
                                        : "Не указана"
                                    ?>
                                </td>
                                <? endif ?>
                            </tr>
                            <tr>
                                <td class="paragraph">
                                    Город:
                                </td>
                                <td class="meaning">
                                    <?=!empty($city) ? $city : "Не указан"?>
                                </td>
                            </tr>
                            <tr>
                                <td class="paragraph">
                                    Статус обучения:
                                </td>
                                <td class="meaning">
                                    <?=$status_name?>
                                </td>
                            </tr>
                            <tr>
                                <td class="paragraph">
                                <?=
                                    $group_name != "none"
                                    ?
                                        <<<HTML
                                            <p>
                                                Группа:
                                            </p>
                                        HTML
                                    : ""
                                ?>
                                </td>
                                <td class="meaning">
                                    <?=
                                        $group_name != "none"
                                        ?
                                            <<<HTML
                                                <p>
                                                    $group_name
                                                </p>
                                            HTML
                                        : ""
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <? if ($user_info['hide_phone'] == 0 or $user_info['hide_email'] == 0): ?>
                    <hr class="line">
                    <p>
                        Контактная информация
                    </p>
                    <div class="info-block">
                        <table>
                            <? if ($user_info['hide_phone'] == 0): ?>
                            <tr>
                                <td class="paragraph">
                                    Номер телефона:
                                </td>
                                <td class="meaning">
                                    <?=$phone?>
                                </td>
                            </tr>
                            <? endif ?>
                            <? if ($user_info['hide_email'] == 0): ?>
                            <tr>
                                <td class="paragraph">
                                    Почта:
                                </td>
                                <td class="meaning">
                                    <?=$email?>
                                </td>
                            </tr>
                            <? endif ?>
                        </table>
                    </div>
                    <? endif ?>
                </div>
                <? endif ?>
            </div>
            <? if ($_GET['category'] == "posts"): ?>
            <?
                $posts = get_user_posts($id); 
                if (!empty($posts))
                {
                    foreach ($posts as $post)
                    {
                        $description_post = $post['description'];
                        $date_of_creation = friendly_date($post['date_of_creation']);
                        $likes = $post['likes'];
            ?>
            <div class="post">
                <!-- Кто запостил. -->
                <div class="flex">
                    <img class="avatar" src="/image/user_icon.png" alt="">
                    <div class="user_indent">
                        <span class="user_name"><?="$firstname $name"?></span>
                        <span class="user_time"><?=$date_of_creation?> написал следующее:</span>
                    </div>
                </div>
                <!-- Текст поста. -->
                <div class="post_text">
                    <?=$description_post?>
                </div>
                <!-- Лайки, комментарии. -->
                <form action="" method="POST" class="flex">
                    <button class="features_background">
                        <img src="/image/like.png" alt="">
                        <span><?=$likes?></span>
                    </button>
                </form>
            </div>
            <?
                    }
                }
            ?>
            <? endif ?>
            <!-- Конец постов. -->
        </main>
        <!-- Конец тела. -->
        <script src="/scripts/script.js"></script>
        <script>
            $('button#write-post').addEventListener('click', () => {
                $('div#modal').style.visibility = "visible";
                $('div#dark-for-modal').style.visibility = "visible";
            })

            $('button#close-modal').addEventListener('click', () => {
                $('div#modal').style.visibility = "hidden";
                $('div#dark-for-modal').style.visibility = "hidden";
            })
        </script>
	</body>
</html>