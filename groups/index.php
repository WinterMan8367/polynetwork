<?
    session_start();

    $server_path = $_SERVER['DOCUMENT_ROOT'];
    require_once("$server_path/php/regular_functions/functions.php");
    require_once("$server_path/php/regular_functions/db_model.php");
?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Группы</title>
        <link rel="shortcut icon" href="/image/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="/styles/variable.css">
        <link rel="stylesheet" href="/styles/reset.css">
        <link rel="stylesheet" href="/groups/styles/styles.css">
	</head>
	<body>

        <!-- Шапка сайта. -->
        <?
            $server_path = $_SERVER['DOCUMENT_ROOT'];
            require_once("$server_path/php/header.php");
        ?>
        <!-- Конец шапки. -->

        <!-- Тело сайта. -->
        <main>

            <!-- Модальные окна. -->
            <!-- Затемнение фона. -->
            <div id="dark-for-modal"></div>

            <!-- Создать сообщество. -->
            <div id="create-group-modal">
                <div class="head">
                    <p>Создание группы</p>
                    <button id="create-group-close-modal">
                        <img src="/image/close.png">
                    </button>
                </div>
                <div class="text-info">
                    <form action="" method="POST" id="create-group-form">
                        <div class="form-row">
                            <p>Название группы (обязательно для заполнения):</p>
                            <div>
                                <input id="input-name" maxlength="50" type="text" name="name" required>
                                <p>0/50 символов</p>
                            </div>
                        </div>
                        <div class="form-row">
                            <p>Краткое описание группы:</p>
                            <div>
                                <textarea maxlength="255" name="description"></textarea>
                                <p>0/255 символов</p>
                            </div>
                        </div>
                        <div class="form-row">
                            <p>Тип группы:</p>
                            <select name="type_of_group">
                                <option value="open">Открытая</option>
                                <option value="close">Закрытая</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="create-group-btn">
                    <input type="submit" form="create-group-form" value="Создать группу">
                </div>
            </div>
            <!-- Конец модальных окон. -->
            
            <div class="main-block container">
                <div class="header">
                    <div class="head">
                        <div class="head-in-head">
                            <p>
                                Группы
                            </p>
                            <button id="create-group">
                                Создать группу
                            </button>
                        </div>
                        <div class="category-links">
                            <a href="?category=my" class="category-menu active-link">
                                Ваши группы
                                <span class="group-count">
                                    10000
                                </span>
                            </a>
                            <a href="?category=admin" class="category-menu">
                                Администрируемые
                                <span class="group-count">
                                    10000
                                </span>
                            </a>
                            <a href="?category=all" class="category-menu">
                                Все группы
                            </a>
                        </div>
                    </div>
                    <form id="search-group" action="#" method="GET">
                        <input name="search-group" type="text" placeholder="Поиск групп">
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
                            <a href="#">Тестовая группа с тестовыми заданиями для теста длинных названий</a>
                            <p>99 999 999 участников</p>
                        </div>
                        <a href="#" class="mobile-link"></a>
                    </div>
                </div>
            </div>
        </main>
        <!-- Конец тела. -->
        <script src="/scripts/script.js"></script>
        <script>
            $('button#create-group').addEventListener('click', () => {
                $('div#create-group-modal').style.visibility = "visible";
                $('div#dark-for-modal').style.visibility = "visible";
            })

            $('button#create-group-close-modal').addEventListener('click', () => {
                $('div#create-group-modal').style.visibility = "hidden";
                $('div#dark-for-modal').style.visibility = "hidden";
            })
        </script>
	</body>
</html>