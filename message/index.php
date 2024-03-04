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

    if (!empty($_GET['send_message']))
    {
        $unique_chat = get_user_chats($_GET['send_message']);
        if (empty($unique_chat))
        {
            create_chat($_GET['send_message'], $_SESSION['user_info']['id']);
            header("Refresh: 0");
            exit;
        }
        else
        {
            $chat_id = $unique_chat[0]['chat_id'];
            header("Location: /message/?chat=$chat_id");
            exit;
        }
    }

    if (!empty($_GET['chat']))
    {
        $actual_chat = get_user_chats($_SESSION['user_info']['id']);
        $count_actual_chat = 0;

        foreach ($actual_chat as $elem)
        {
            if ($elem['chat_id'] != $_GET['chat'])
            {
                continue;
            }
            else
            {
                $count_actual_chat += 1;
            }
        }

        if ($count_actual_chat == 0)
        {
            $not_found = "true";
        }
    }

    if (!empty($_POST['text']))
    {
        write_message($_SESSION['user_info']['id'], $_GET['chat'], $_POST['text']);
        unset($_POST);
    }
?>

<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Сообщения</title>
        <link rel="shortcut icon" href="/image/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="/styles/variable.css">
        <link rel="stylesheet" href="/styles/reset.css">
        <link rel="stylesheet" href="/message/styles/styles.css">
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
            <div class="main-block container message-block">
                <div class="message-users
                <?= !empty($_GET['chat']) ? " mobile-chat-active" : "" ?>
                ">
                    <div class="search-message">
                        <form action="" method="GET">
                            <img src="/image/search.png">
                            <input name="search-message">
                        </form>
                    </div>
                    <div class="list-users">
                        <?
                            $user_chats = get_user_chats($_SESSION['user_info']['id']);

                            if (!empty($user_chats))
                            {
                                $other_users_in_chat = [];
                                foreach ($user_chats as $elem)
                                {
                                    $other_users_in_chat[] = get_users_in_chat($elem['chat_id']);
                                }
    
                                $other_users_info = [];
                                foreach ($other_users_in_chat as $key => $elem)
                                {
                                    foreach ($elem as $value)
                                    {
                                        if ($value['user_id'] != $_SESSION['user_info']['id'])
                                        {
                                            $other_users_info[$key] = getAllUserInfo($value['user_id']);
                                            $other_users_info[$key]['chat_id'] = $value['chat_id'];
                                        }
                                    }
                                }

                                foreach ($user_chats as $chat)
                                {
                                    foreach ($other_users_info as $other_user_info)
                                    {
                                        if ($other_user_info['chat_id'] == $chat['chat_id'])
                                        {
                                            $user_id = $other_user_info['id'];
                                            $firstname = $other_user_info['firstname'];
                                            $name = $other_user_info['name'];
                                            break;
                                        }
                                    }

                                    $style = "";
                                    if (!empty($_GET['chat']))
                                    {
                                        if ($_GET['chat'] == $chat['id'])
                                        {
                                            $style = " style='background-color: var(--light-grey-background-color);' ";
                                        }
                                    }

                                    echo <<<HTML
                                        <a href="?chat=$chat[chat_id]" class="list-item" $style>
                                            <img class="user-avatar" src="/image/user_icon.png">
                                            <div class="name-and-text">
                                                <p class="user-name">
                                                    $firstname $name
                                                </p>
                                                <div class="user-text">
                                                    <span>Последнее сообщение</span>
                                                    <!-- <span class="message-notification">
                                                        <span class="message-notification-number">15</span>
                                                    </span>
                                                    Уведомления будут позже -->
                                                </div>
                                                <span class="message-time">
                                                    00:00
                                                </span>
                                            </div>
                                        </a>
                                    HTML;
                                }
                            }
                            else
                            {
                                echo <<<HTML
                                    <p style="display: flex; justify-content: center; align-items: center; width: 100%; height: 100%; text-align: center">
                                        Вы пока ещё не начинали общение.
                                    </p>
                                HTML;
                            }
                            
                        ?>
                    </div>
                </div>
                <div class="chat-is-closed" style="<?= !empty($_GET['chat']) ? "display: none" : "" ?>">
                    Выберите пользователя или беседу и начните общение!
                </div>
                <? if (!isset($not_found)): ?>
                <div class="message-chat" 
                style="
                <?= empty($_GET['chat']) ? "display: none" : "" ?>
                "
                >
                    <?
                            $users_in_chat = get_users_in_chat($_GET['chat']);
                            foreach ($users_in_chat as $elem)
                            {
                                if ($elem['user_id'] != $_SESSION['user_info']['id'])
                                {
                                    $user_info = getAllUserInfo($elem['user_id']);
                                    $id = $user_info['id'];
                                    $firstname = $user_info['firstname'];
                                    $name = $user_info['name'];
                                }
                            }
                            echo <<<HTML
                                <div class="chat-head">
                                    <a href="/profile/?id=$id" class="photo-and-name">
                                        <img src="/image/user_icon.png">
                                        <p>$firstname $name</p>
                                    </a>
                                    <div class="btn">
                                        <button type="button" id="search-message">
                                            <img src="/image/search.png">
                                        </button>
                                        <button type="button" id="settings-user-chat">
                                            <img src="/image/settings.png">
                                        </button>
                                        <a type="button" href="/message/" id="close-chat">
                                            <img src="/image/close.png">
                                        </a>
                                    </div>
                                </div>
                            HTML;
                    ?>
                    <div class="chat-block">
                        <ul class="message-list">
                            <?
                                    $messages = get_messages_in_chat($_GET['chat']);
                                    if (!empty($messages))
                                    {
                                        foreach ($messages as $message)
                                        {
                                            $message_text = $message['text'];
                                            $message_time = friendly_date($message['dispatch_time']);
        
                                            if ($message['user_id'] == $_SESSION['user_info']['id'])
                                            {
                                                $sender = "my-message";
                                            }
                                            else
                                            {
                                                $sender = "other-message";
                                            }
        
                                            echo <<<HTML
                                                <li class="message-item $sender">
                                                    <img src="/image/user_icon.png">
                                                    <p>
                                                        $message_text
                                                    </p>
                                                    <span class="message-time">
                                                        $message_time
                                                    </span>
                                                </li>
                                            HTML;
                                        }
                                    }
                                    else
                                    {
                                        echo <<<HTML
                                            <div style="margin-top: 20px; display: flex; justify-content: center">
                                                Здесь пока нет сообщений.
                                            </div>
                                        HTML;
                                    }
                            ?>
                        </ul>
                    </div>
                    <div class="send-message">
                        <form action="" method="POST">
                            <!-- <div role="textbox" contenteditable="true" aria-multiline="true"></div> -->
                            <textarea name="text" id="textbox_for_message"></textarea>
                            <div class="load-file">
                                <input id="input-file" name="load-file" type="file">
                                <label for="input-file">
                                    <img src="/image/load_file.png">
                                </label>
                            </div>
                            <div class="send-text">
                                <input id="input-send" type="submit">
                                <label for="input-send">
                                    <img src="/image/enter.png">
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
                <? else: ?>
                <div style="display: flex; justify-content: center; align-items: center; width: 100%; height: 100%; text-align: center">
                    Вы не состоите в этом чате или его не существует.
                </div>
                <? endif; ?>
            </div>
        </main>
        <!-- Конец тела. -->
        <script src="/scripts/script.js"></script>
        <script>
            // Прокрутить страницу до последнего элемента (в самый низ).
            document.addEventListener("DOMContentLoaded", function(event) {
                var offsetY = document.querySelectorAll('li.message-item');
                var lastElement = offsetY[offsetY.length - 1].offsetTop;
                $('div.chat-block').scrollTo(0, lastElement);
            });
        </script>
	</body>
</html>
<?
    // echo "<div style='position: fixed; bottom: 0; left: 0; z-index: 999999; background-color: black; color: white; padding: 1rem'>";
    // var_dump(isset($not_found));
    // echo "</div>";
?>