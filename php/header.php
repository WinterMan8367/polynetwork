<header>

    <!-- Стили шапки. -->
    <link rel="stylesheet" href="/styles/header.css">
    <!-- ! -->

    <?
        if (!empty($_SESSION))
        {
            $firstname = $_SESSION['user_info']['firstname'];
            $name = $_SESSION['user_info']['name'];
            $user_id = $_SESSION['user_info']['id'];

            echo <<<HTML
                <div class="container">

                    <!-- Десктопная версия после 768 пикселей. -->
                    <div class="menu desktop-visible">
                        <div id="logo"></div>
                        <div class="menu-links">
                            <a href="/news">
                                <img src="/image/news.png">
                                <p>Новости</p>
                            </a>
                            <a href="/message">
                                <div class="icon-with-notification">
                                    <img src="/image/message.png">
                                    <span class="notification">
                                        <span class="notification-number">15</span>
                                    </span>
                                </div>
                                <p>Беседа</p>
                            </a>
                            <a href="/friends">
                                <div class="icon-with-notification">
                                    <img src="/image/friend.png">
                                    <span class="notification">
                                        <span class="notification-number">5</span>
                                    </span>
                                </div>
                                <p>Одногруппники</p>
                            </a>
                            <a href="/groups">
                                <div class="icon-with-notification">
                                    <img src="/image/group.png">
                                    <span class="notification">
                                        <span class="notification-number">5</span>
                                    </span>
                                </div>
                                <p>Группы</p>
                            </a>
                            <a href="/photos">
                                <img src="/image/photo.png">
                                <p>Фотографии</p>
                            </a>
                            <a href="/videos">
                                <img src="/image/video.png">
                                <p>Видеозаписи</p>
                            </a>
                            <a href="/documents">
                                <img src="/image/document.png">
                                <p>Документы</p>
                            </a>
                            <a href="/notifications">
                                <div class="icon-with-notification">
                                    <img src="/image/notification.png">
                                    <span class="notification">
                                        <span class="notification-number">5</span>
                                    </span>
                                </div>
                                <p>Уведомления</p>
                            </a>
                        </div>
                    </div>
                    <div class="menu desktop-visible">
                        <form action="" method="GET">
                            <img class="desktop-visible" src="/image/search.png">
                            <input name="search" placeholder="Поиск">
                        </form>

                        <!-- Всплывающее окно при нажатии на иконку профиля. -->
                        <div class="pop-up-menu">
                            <input id="pop-up-menu-toggle" type="checkbox">
                            <label class="pop-up-menu-btn" for="pop-up-menu-toggle">
                                <img src="/image/user_icon.png">
                                <img src="/image/down.png">
                            </label>
                            <div class="pop-up-menu-box">
                                <a class="pop-up-menu-item" href="/profile/?id=$user_id" data-profile>
                                    <img src="/image/user_icon.png">
                                    <div>
                                        <p>$firstname $name</p>
                                        <span>Перейти в профиль</span>
                                    </div>
                                </a>
                                <hr>
            HTML;
                                if ($_SESSION['user_info']['role_name'] == 'admin')
                                {
                                    echo <<<HTML
                                        <a class="pop-up-menu-item" href="/">
                                            <img src="/image/settings.png">
                                            <p>Панель администратора</p>
                                        </a>
                                    HTML;
                                }
            echo <<<HTML
                                <a class="pop-up-menu-item" href="/settings">
                                    <img src="/image/settings.png">
                                    <p>Настройки</p>
                                </a>
                                <a class="pop-up-menu-item" href="/logout">
                                    <img src="/image/logout.png">
                                    <p>Выйти</p>
                                </a>
                            </div>
                        </div>
                        <!-- Конец всплывающего окна. -->
                    </div>

                    <!-- Планшетно-мобильная версия до 768 пикселей. -->
                    <div class="menu mobile-visible">
                        <a href="/news">
                            <img src="/image/news.png">
                            <p class="active" href="#">Новости</p>
                        </a>
                        <a href="#">
                            <img src="/image/search.png">
                            <p class="active" href="#">Поиск</p>
                        </a>
                        <a href="/message">
                            <div class="icon-with-notification">
                                <img src="/image/message.png">
                                <span class="notification">
                                    <span class="notification-number">15</span>
                                </span>
                            </div>
                            <p class="active" href="#">Беседа</p>
                        </a>
                        <a href="/notifications">
                            <div class="icon-with-notification">
                                <img src="/image/notification.png">
                                <span class="notification">
                                    <span class="notification-number">5</span>
                                </span>
                            </div>
                            <p class="active" href="#">Уведомления</p>
                        </a>

                        <!-- Бутер-меню. -->
                        <div class="humburger-menu">
                            <input id="menu-toggle" type="checkbox">
                            <div class="menu-dark"></div>
                            <label class="menu-btn" for="menu-toggle">
                                <span></span>
                            </label>
                            <div class="menu-box">
                                <p>Ещё</p>
                                <a class="menu-item" href="/profile/?id=$user_id" data-profile>
                                    <img src="/image/user_icon.png">
                                    <div>
                                        <p>$firstname $name</p>
                                        <span>Перейти в профиль</span>
                                    </div>
                                </a>
                                <hr>
                                <a class="menu-item" href="/friends" data-with-notifications>
                                    <div class="notification-burger">
                                        <img src="/image/friend.png">
                                        <p>Одногруппники</p>
                                    </div>
                                    <span class="notification" data-mobile>
                                        <span class="notification-number">5</span>
                                    </span>
                                </a>
                                <a class="menu-item" href="/groups" data-with-notifications>
                                    <div class="notification-burger">
                                        <img src="/image/group.png">
                                        <p>Группы</p>
                                    </div>
                                    <span class="notification" data-mobile>
                                        <span class="notification-number">5</span>
                                    </span>
                                </a>
                                <a class="menu-item" href="/photos">
                                    <img src="/image/photo.png">
                                    <p>Фотографии</p>
                                </a>
                                <a class="menu-item" href="/videos">
                                    <img src="/image/video.png">
                                    <p>Видеозаписи</p>
                                </a>
                                <a class="menu-item" href="/documents">
                                    <img src="/image/document.png">
                                    <p>Документы</p>
                                </a>
                                <hr>
                                <a class="menu-item" href="/settings">
                                    <img src="/image/settings.png">
                                    <p>Настройки</p>
                                </a>
                                <a class="menu-item" href="/logout">
                                    <img src="/image/logout.png">
                                    <p>Выйти</p>
                                </a>
                            </div>
                        </div>
                        <!-- Конец бургера. -->
                    </div>
                </div>
            HTML;
        }
        else
        {
            echo <<<HTML
                <style>
                    @media (max-width: 1200px)
                    {
                        #logo { margin-left: 20px }
                        #logo ~ a { margin-right: 20px }
                    }
                </style>
                <div class="container">
                    <div id="logo"></div>
                    <a href="/login" style="font-weight: bold">Вход</a>
                </div>
            HTML;
        }
    ?>

</header>