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
		<title>Документы</title>
        <link rel="shortcut icon" href="/image/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="/styles/variable.css">
        <link rel="stylesheet" href="/styles/reset.css">
        <link rel="stylesheet" href="/documents/styles/styles.css">
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

            <!-- Загрузка файла. -->
            <div id="load-file-modal">
                <div class="head">
                    <p>Загрузка файла</p>
                    <button id="load-file-close-modal">
                        <img src="/image/close.png">
                    </button>
                </div>
                <div class="text-info">
                    <p>
                        Ограничения
                    </p>
                    <ul>
                        <li>Файл не должен превышать 20 МБ.</li>
                        <li>Поддерживаемые типы файлов: doc, docx, xls, xlsx, ppt, pptx, rtf, pdf, png, jpg, gif, psd, djvu, fb2, ps и другие.</li>
                        <li>Файл не должен нарушать авторские права.</li>
                    </ul>
                </div>
                <div class="load-file-btn">
                    <form action="#" method="GET">
                        <input id="load-file-input" name="file" type="file" style="display: none">
                        <label for="load-file-input">
                            <div class="filename">Файл не выбран</div>
                            <div class="input-btn">Выбрать</div>
                        </label>
                        <input type="submit">
                    </form>
                </div>
            </div>

            <!-- Удаление файла. -->
            <div class="delete-file-btn" style="display: none">
                <p>
                    Удалить файл <span>Имя_файла.расширение</span>?
                </p>
                <div>
                    <button type="button" id="delete-file-yes">
                        Да
                    </button>
                    <button type="button" id="delete-file-no">
                        Нет
                    </button>
                </div>
            </div>
            <!-- Конец модальных окон. -->

            <div class="main-block container">
                <div class="header">
                    <div class="head">
                        <p>
                            Документы
                            <span class="files-count">
                                15
                            </span>
                        </p>
                        <button id="load-file">
                            Загрузить файл
                        </button>
                    </div>
                    <form id="search-file" action="#" method="GET">
                        <input name="search-file" type="text" placeholder="Поиск файлов">
                        <input id="search-submit" type="submit">
                        <label for="search-submit">
                            <img src="/image/search.png">
                        </label>
                    </form>
                </div>
                <div class="user-documents">
                    <div class="document">
                        <div>
                            <img src="/image/document.png">
                            <div class="document-info">
                                <a class="file-name" href="#">
                                    Имя_файла.расширение
                                </a>
                                <div class="size-and-date">
                                    <span>999 МБ,</span>
                                    <span>31 декабря 1999 г. в 23:59</span>
                                </div>
                            </div>
                        </div>
                        <button class="delete-file">
                            <img src="/image/delete.png">
                        </button>
                    </div>
                </div>
            </div>
        </main>
        <!-- Конец тела. -->
        <script src="/scripts/script.js"></script>
        <script>
            $all('button.delete-file').forEach(item => {
                item.addEventListener('click', () => {
                    $('div.delete-file-btn').removeAttribute('style');
                    $('div#dark-for-modal').style.visibility = "visible";
                })
            });

            $all('button#delete-file-yes').forEach(item => {
                item.addEventListener('click', () => {
                    $('div.delete-file-btn').style.display = "none";
                    $('div#dark-for-modal').style.visibility = "hidden";
                })
            });

            $all('button#delete-file-no').forEach(item => {
                item.addEventListener('click', () => {
                    $('button.delete-file').removeAttribute('style');
                    $('div.delete-file-btn').style.display = "none";
                    $('div#dark-for-modal').style.visibility = "hidden";
                })
            });

            $('button#load-file').addEventListener('click', () => {
                $('div#load-file-modal').style.visibility = "visible";
                $('div#dark-for-modal').style.visibility = "visible";
            })

            $('button#load-file-close-modal').addEventListener('click', () => {
                $('div#load-file-modal').style.visibility = "hidden";
                $('div#dark-for-modal').style.visibility = "hidden";
            })
        </script>
        <script>
            // let inputs = document.querySelectorAll('#load-file-input');
            // Array.prototype.forEach.call(inputs, function (input) {
            //     let label = input.nextElementSibling,
            //     labelVal = label.querySelector('.button-text').innerText;
          
            //     input.addEventListener('change', function (e) {
            //     let countFiles = '';
            //     if (this.files && this.files.length >= 1)
            //         countFiles = this.files.length;
            //     if (countFiles)
            //         label.querySelector('.button-text').innerText = document.getElementById('load-file-input').files.item(0).name;
            //     else
            //         label.querySelector('.button-text').innerText = 'Выбрать файл';
            //   });
            // });

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