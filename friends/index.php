<?
    session_start();

    $server_path = $_SERVER['DOCUMENT_ROOT'];
    require_once("$server_path/php/regular_functions/functions.php");
    require_once("$server_path/php/regular_functions/db_model.php");

    if (empty($_GET))
    {
        header("Location: ?category=my");
        exit;
    }

    $category = $_GET['category'];
?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Друзья</title>
        <link rel="shortcut icon" href="/image/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="/styles/variable.css">
        <link rel="stylesheet" href="/styles/reset.css">
        <link rel="stylesheet" href="/friends/styles/styles.css">
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

            <!-- Фильтрация поиска. -->
            <div id="extended-sort-modal">
                <div class="head">
                    <p>Расширенный поиск</p>
                    <button id="extended-sort-close">
                        <img src="/image/close.png">
                    </button>
                </div>
                <div class="text-info">
                    <form id="extended-sort-form" action="" method="GET">
                        <div class="sort">
                            <p>Сортировка:</p>
                            <select name="sort">
                                <option>По дате регистрации</option>
                                <option>По дате рождения</option>
                                <option>В алфавитном порядке</option>
                            </select>
                            <div class="sort-radio">
                                <div class="radio">
                                    <input type="radio" name="type_of_sort" value="down" checked>
                                    <p>По убыванию</p>
                                </div>
                                <div class="radio">
                                    <input type="radio" name="type_of_sort" value="up">
                                    <p>По возрастанию</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <p>Город:</p>
                            <input type="text" name="city">
                        </div>
                        <div>
                            <p>Возраст:</p>
                            <div>
                                <div class="age">
                                    <p>От:</p>
                                    <input type="text" name="min_age">
                                </div>
                                <div class="age">
                                    <p>До:</p>
                                    <input type="text" name="max_age">
                                </div>
                            </div>
                        </div>
                        <div>
                            <p>Пол:</p>
                            <div class="radio">
                                <input type="radio" name="sex" value="all" checked>
                                <p>Любой</p>
                            </div>
                            <div class="radio">
                                <input type="radio" name="sex" value="male">
                                <p>Мужской</p>
                            </div>
                            <div class="radio">
                                <input type="radio" name="sex" value="female">
                                <p>Женский</p>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="extended-sort-btn">
                    <input type="submit" form="extended-sort-form" value="Найти">
                </div>
            </div>
            <!-- Конец модальных окон. -->

            <div class="main-block container">
                <div class="header">
                    <div class="head">
                        <div class="head-in-head">
                            <p>
                                <?
                                    switch ($category)
                                    {
                                        case 'my':
                                            echo "Друзья";
                                        break;
                                        case 'online':
                                            echo "Друзья онлайн";
                                        break;
                                        case 'request':
                                            echo "Входящие заявки";
                                        break;
                                        case 'out_request':
                                            echo "Исходящие заявки";
                                        break;
                                        case 'all':
                                            echo "Поиск друзей";
                                        break;
                                    }
                                ?>
                            </p>
                            <?
                                if ($category == 'all')
                                {
                                    echo <<<HTML
                                        <button id="extended-sort">
                                            Расширенный поиск
                                        </button>
                                    HTML;
                                }
                                if ($category != 'all')
                                {
                                    echo <<<HTML
                                        <a href="?category=all" id="find-friends">
                                            Найти друзей
                                        </a>
                                    HTML;
                                }
                            ?>
                        </div>
                        <div class="category-links">
                            <a href="?category=my" class="<?=$category == 'my' ? "active-link" : "" ?> category-menu">
                                Ваши друзья
                                <span class="group-count">
                                    10000
                                </span>
                            </a>
                            <a href="?category=online" class="<?=$category == 'online' ? "active-link" : "" ?> category-menu">
                                Друзья онлайн
                                <span class="group-count">
                                    10000
                                </span>
                            </a>
                            <a href="?category=request" class="<?=$category == 'request' ? "active-link" : "" ?> category-menu">
                                Входящие заявки
                                <span class="group-count">
                                    10000
                                </span>
                            </a>
                            <a href="?category=out_request" class="<?=$category == 'out_request' ? "active-link" : "" ?> category-menu">
                                Исходящие заявки
                                <span class="group-count">
                                    10000
                                </span>
                            </a>
                        </div>
                    </div>
                    <form id="search-group" action="#" method="GET">
                        <input name="search-group" type="text" placeholder="Поиск друзей">
                        <input id="search-submit" type="submit">
                        <label for="search-submit">
                            <img src="/image/search.png">
                        </label>
                    </form>
                </div>
                <div class="my-groups">
                    <div class="group">
                        <a href="#">
                            <img src="/image/user_icon.png">
                        </a>
                        <div class="group-info">
                            <a href="#">Абракадабров Абракадабр</a>
                            <a href="#">Написать сообщение</a>
                        </div>
                        <div class="mobile-version">
                            <a href="#" class="mobile-link"></a>
                            <p>Абракадабров Абракадабр</p>
                            <a href="#message" class="message-link">
                                <img src="/image/message.png">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- Конец тела. -->
        <script src="/scripts/script.js"></script>
        <script>
            $('button#extended-sort').addEventListener('click', () => {
                $('div#extended-sort-modal').style.visibility = "visible";
                $('div#dark-for-modal').style.visibility = "visible";
            })

            $('button#extended-sort-close').addEventListener('click', () => {
                $('div#extended-sort-modal').style.visibility = "hidden";
                $('div#dark-for-modal').style.visibility = "hidden";
            })
        </script>
	</body>
</html>