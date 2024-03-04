<?
    require_once('db_model.php');

    function test($arr, $name = 'Array')
    {
        if (is_array($arr) == true)
        {
            $margin = "-------";
            echo "$name [<br>";
            foreach ($arr as $key => $elem)
            {
                if (is_array($elem) == false)
                {
                    echo $margin, "[$key] => [$elem]<br>";
                }
                else
                {
                    echo $margin, "[$key] => Array [<br>";
                    foreach ($elem as $key2 => $elem2)
                    {
                        if (is_array($elem2) == false)
                        {
                            echo $margin, $margin, "[$key2] => [$elem2]<br>";
                        }
                        else
                        {   
                            echo $margin, $margin, "[$key] => Array [<br>";
                            foreach ($elem2 as $key3 => $elem3)
                            {
                                if (is_array($elem3) == false)
                                {
                                    echo $margin, $margin, $margin, "[$key3] => [$elem3]<br>";
                                }
                                else
                                {
                                    echo $margin, $margin, $margin, "[$key] => Array [<br>";
                                    foreach ($elem3 as $key4 => $elem4)
                                    {
                                        if (is_array($elem4) == false)
                                        {
                                            echo $margin, $margin, $margin, $margin, "[$key4] => [$elem4]<br>";
                                        }
                                        else
                                        {
                                            echo $margin, $margin, $margin, $margin, "[$key] => Array<br>";
                                        }
                                    }
                                    echo $margin, $margin, $margin, $margin, "]<br>";
                                }
                            }
                            echo $margin, $margin, $margin, "]<br>";
                        }
                    }
                    echo $margin, $margin, "]<br>";
                }
            }
            echo $margin, "]<br>";
        }
        else
        {
            echo "Это не массив!";
        }
    }

    function get_email_and_phone($email, $phone)
    {
        $arr = [];
        $db = new MysqlModel();

        $arr = $db->goResultOnce("
            SELECT 
                * 
            FROM
                users
            WHERE
                email = '$email'
                OR phone = '$phone'
        ");

        return $arr;
    }

    function preg_check($input, $type)
    {
        switch ($type)
        {
            case "phone":
                $pattern = '/[A-Za-zА-Яа-я]/';
                break;
            case "email":
                $pattern = '/[^A-Za-z0-9\@\.\-\_]/';
                break;
            case "only_letters":
                $pattern = '/[^АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюяA-Za-z\-]/';
                break;
            case "password";
                $pattern = '/[А-Яа-я]/';
                break;
        }

        return preg_match($pattern, $input);
    }

    function registration($firstname, $name, $lastname, $email, $phone, $password, $repeat_password, $sex)
    {
        if (preg_check($phone, "phone") == 1)
        {
            return 'incorrect_phone';
        }

        if (preg_check($email, "email") == 1)
        {
            return 'cyrillic_email';
        }

        $fullname = "$firstname"."$name"."$lastname";

        if (preg_check($fullname, "only_letters") == 1)
        {
            return 'incorrect_character';
        }

        if ($password == $repeat_password)
        {
            if (preg_check($password, "password") == 1)
            {
                return 'cyrillic';
            }

            $phone = preg_replace('/[^0-9]/', "", $phone);
            
            $email_phone_arr = get_email_and_phone($email, $phone);

            if ($email_phone_arr == null)
            {
                if (empty($lastname))
                {
                    $lastname = "NULL";
                }
                else
                {
                    $lastname = "'$lastname'";
                }

                $password = password_hash($password, PASSWORD_BCRYPT);

                $arr = [];
                $db = new MysqlModel();
                $arr = $db->query("
                    INSERT INTO users(
                        `id`,
                        `login`,
                        `password_hash`,
                        `email`,
                        `phone`,
                        `firstname`,
                        `name`,
                        `lastname`,
                        `sex`,
                        `date_of_registration`,
                        `last_update`,
                        `role_id`
                    )
                    VALUES(
                        NULL,
                        NULL,
                        '$password',
                        '$email',
                        '$phone',
                        '$firstname',
                        '$name',
                        $lastname,
                        '$sex',
                        CURRENT_TIMESTAMP,
                        CURRENT_TIMESTAMP,
                        '1'
                    )
                ");

                $arr = $db->goResultOnce("
                    SELECT
                        id
                    FROM
                        users
                    WHERE
                        email = '$email'
                ");

                $user_id = $arr['id'];

                $arr = $db->query("
                    INSERT INTO `user_info`(
                        `id`,
                        `user_id`,
                        `status`,
                        `date_of_birth`,
                        `city`,
                        `spt_group_id`,
                        `learning_status_id`,
                        `about_me`
                    )
                    VALUES(
                        '$user_id',
                        '$user_id',
                        NULL,
                        NULL,
                        NULL,
                        '0',
                        '0',
                        NULL
                    )
                ");

                $arr = $db->query("
                    INSERT INTO `user_settings`(
                        `id`,
                        `user_id`,
                        `hide_lastname`,
                        `hide_email`,
                        `hide_phone`,
                        `hide_date_of_birth`,
                        `type_of_profile`,
                        `avatar_file`
                    )
                    VALUES(
                        $user_id,
                        $user_id,
                        0,
                        0,
                        1,
                        1,
                        0,
                        'none'
                    )
                ");

                return 'access';
            }
            else
            {
                if ($email_phone_arr['email'] == $email) return 'email';
                if ($email_phone_arr['phone'] == $phone) return 'phone';
                return 'test';
            }
        }
        else
        {
            return 'password';
        } 
    }

    function view_notification($notification)
    {
        switch ($notification)
        {
            case 'password':
                $text = "Пароли не совпадают.";
                $color = "#FF0000";
                break;
            case 'email':
                $text = "Такая почта уже существует.";
                $color = "#FF0000";
                break;
            case 'phone':
                $text = "Такой номер уже существует.";
                $color = "#FF0000";
                break;
            case 'access':
                $text = "Успешно!";
                $color = "#00FF00";
                break;
            case 'required':
                $text = "Не все поля заполнены.";
                $color = "#FF0000";
                break;
            case 'incorrect':
                $text = "Неправильный логин или пароль.";
                $color = "#FF0000";
                break;
            case 'incorrect_phone':
                $text = "Некорректное значение номера телефона, номер не должен содержать букв.";
                $color = "#FF0000";
                break;
            case 'incorrect_character':
                $text = "Фамилия, имя или отчество содержат некорректные символы, допустимы только кириллица и латиница.";
                $color = "#FF0000";
                break;
            case 'incorrect_character_in_city':
                $text = "Название города содержит некорректные символы, допустимы только кириллица и латиница.";
                $color = "#FF0000";
                break;
            case 'cyrillic_email':
                $text = "Электронная почта не должна содержать кириллицы и любые символы, кроме @ и точки.";
                $color = "#FF0000";
                break;
            case 'cyrillic':
                $text = "Пароль не должен содержать кириллицы.";
                $color = "#FF0000";
                break;
            default:
                $text = "Неизвестная ошибка. Сообщите администратору.";
                $color = "grey";
                break;
        }
        echo <<<HTML
            <div id="error" style="
                position: fixed;
                top: 0;
                left: 0;
                z-index: 99999;
                padding: .5rem 20px;
                box-sizing: border-box;
                margin: 20px 20px 0 20px;
                width: calc(100% - 40px);
                height: auto;
                background-color: $color;
                color: var(--white);
                border-radius: 5px;
            ">
                $text
            </div>
        HTML;
    }


    function authorization($login, $password)
    {
        $arr = [];
        $db = new MysqlModel();

        $arr = $db->goResultOnce("
            SELECT 
                * 
            FROM
                users
            WHERE
                email = '$login'
                    OR
                phone = '$login'
                    OR
                login = '$login'   
        ");

        if (!empty($arr))
        {
            $password_hash = $arr['password_hash'];
            $verify = password_verify($password, $password_hash);

            return $result = $verify == true ? $arr : false;
        }
        else
        {
            return false;
        }
    }

    function getAllUserInfo($value)
    {
        $arr = [];
        $db = new MysqlModel();

        $arr = $db->goResultOnce("
            SELECT
                users.id,
                users.login,
                users.password_hash,
                users.email,
                users.phone,
                users.firstname,
                users.name,
                users.lastname,
                users.sex,
                users.date_of_registration,
                users.last_update,
                user_info.status,
                user_info.date_of_birth,
                user_info.city,
                user_info.about_me,
                user_settings.hide_lastname,
                user_settings.hide_email,
                user_settings.hide_phone,
                user_settings.hide_date_of_birth,
                user_settings.type_of_profile,
                user_settings.avatar_file,
                spt_group.group_name,
                learning_status.status_name,
                role.role_name
            FROM
                users,
                user_info,
                user_settings,
                spt_group,
                learning_status,
                role
            WHERE
                (password_hash = '$value' OR users.id = '$value')
                AND users.id = user_info.user_id
                AND users.id = user_settings.user_id
                AND user_info.spt_group_id = spt_group.id
                AND user_info.learning_status_id = learning_status.id
                AND users.role_id = role.id
        ");

        return $arr;
    }

    function search_id($id)
    {
        $arr = [];
        $db = new MysqlModel();

        $arr = $db->goResultOnce("
            SELECT
                *
            FROM
                users
            WHERE
                id = '$id'
        ");

        return $arr;
    }

    function view_error($error_code)
    {
        $text_low = "";

        switch ($error_code)
        {
            case 404:
                $text = "Такой страницы не существует :(";
                break;
            case 'profile_not_found':
                $text = "Такого профиля не существует :(";
                break;
            case 'profile_not_selected':
                $text = "Профиль пуст :(";
                $text_low = "Зарегистрируйтесь или войдите в профиль, чтобы отобразить информацию.";
                break;
            default:
                $text = "Неизвестная ошибка О_о ?";
                break;
        }

        echo <<<HTML
            <!DOCTYPE html>
            <html lang="ru">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Ошибка!</title>
                    <link rel="shortcut icon" href="/image/favicon.ico" type="image/x-icon">
                    <link rel="stylesheet" href="/styles/variable.css">
                    <link rel="stylesheet" href="/styles/reset.css">
                </head>
                <body>
                    <div style="
                        font-size: 40px;
                        background-color: var(--blue-tech);
                        color: var(--white);
                        width: 100vw;
                        height: 100vh;
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                        align-items: center;
                        gap: 15px;
                        text-align: center
                    ">
                        $text
                        <span style="font-size: 20px">$text_low</span>
                    </div>
                </body>
            </html>
        HTML;
        exit;
    }

    function friendly_date($date)
    {
        $date_and_time = explode(" ", $date);

        $date_nums = explode("-", $date_and_time[0]);

        if (count($date_and_time) == 2)
        {
            $time_nums = explode(":", $date_and_time[1]);
        }

        if ($date_nums[2][0] == "0")
        {
            $date_nums[2] = mb_substr($date_nums[2], 1);
        }

        switch ($date_nums[1])
        {
            case 1:
                $date_nums[1] = "января";
            break;
            case 2:
                $date_nums[1] = "февраля";
            break;
            case 3:
                $date_nums[1] = "марта";
            break;
            case 4:
                $date_nums[1] = "апреля";
            break;
            case 5:
                $date_nums[1] = "мая";
            break;
            case 6:
                $date_nums[1] = "июня";
            break;
            case 7:
                $date_nums[1] = "июля";
            break;
            case 8:
                $date_nums[1] = "августа";
            break;
            case 9:
                $date_nums[1] = "сентября";
            break;
            case 10:
                $date_nums[1] = "октября";
            break;
            case 11:
                $date_nums[1] = "ноября";
            break;
            case 12:
                $date_nums[1] = "декабря";
            break;
        }

        $date = "$date_nums[2] $date_nums[1] $date_nums[0] г.";

        if (count($date_and_time) == 2)
        {
            $date .= " в $time_nums[0]:$time_nums[1]:$time_nums[2]";
        }

        return $date;
    }

    function get_user_chats($id)
    {
        $arr = [];
        $db = new MysqlModel();

        $arr = $db->goResult("
            SELECT
                *
            FROM
                chats_conn_users conn,
                chats
            WHERE
                user_id = $id AND conn.chat_id = chats.id
            ORDER BY
                chats.last_update DESC
        ");

        return $arr;
    }

    function create_chat($user_id, $session_user_id)
    {
        $arr = [];
        $db = new MysqlModel();

        $arr = $db->query("
            INSERT INTO `chats`(
                `id`,
                `title`,
                `owner_id`,
                `add_in_chat`,
                `last_update`
            )
            VALUES(
                NULL,
                NULL,
                NULL,
                0,
                CURRENT_TIMESTAMP
            )
        ");

        $arr = $db->goResultOnce("
            SELECT
                *
            FROM
                chats
            ORDER BY
                id DESC
        ");

        $chat_id = $arr['id'];

        $arr = $db->query("
            INSERT INTO `chats_conn_users`(
                `id`,
                `chat_id`,
                `user_id`
            )
            VALUES(
                NULL,
                '$chat_id',
                '$user_id'
            ),
            (
                NULL,
                '$chat_id',
                '$session_user_id'
            )
        ");
    }

    function get_messages_in_chat($chat_id)
    {
        $arr = [];
        $db = new MysqlModel();

        $arr = $db->goResult("
            SELECT
                *
            FROM
                messages
            WHERE
                chat_id = '$chat_id'
        ");

        return $arr;
    }

    function write_message($user_id, $chat_id, $text)
    {
        $arr = [];
        $db = new MysqlModel();

        $arr = $db->query("
            INSERT INTO messages(
                id,
                user_id,
                chat_id,
                text,
                dispatch_time
            )
            VALUES(
                NULL,
                '$user_id',
                '$chat_id',
                '$text',
                CURRENT_TIMESTAMP
            )
        ");

        $arr = $db->query("
            UPDATE
                `chats`
            SET
                `last_update` = CURRENT_TIMESTAMP
            WHERE
                `chats`.`id` = '$chat_id'
        ");
    }

    function get_users_in_chat($chat_id)
    {
        $arr = [];
        $db = new MysqlModel();

        $arr = $db->goResult("
            SELECT
                *
            FROM
                chats_conn_users
            WHERE
                chat_id = '$chat_id'
        ");

        return $arr;
    }

    function update_online($user_id)
    {
        $arr = [];
        $db = new MysqlModel();

        $arr = $db->query("
            UPDATE
                `users`
            SET
                `last_update` = CURRENT_TIMESTAMP
            WHERE
                id = $user_id
        "); 
    }

    function update_user_main($id, $firstname, $name, $lastname, $date_of_birth, $city, $status, $avatar_file, $sex, $about_me)
    {
        $arr = [];
        $db = new MysqlModel();

        if (empty($firstname) or empty($name))
        {
            return 'required';
        }

        $fullname = "$firstname"."$name"."$lastname";
        if (preg_check($fullname, "only_letters") == 1)
        {
            return 'incorrect_character';
        }

        if (preg_check($city, "only_letters") == 1)
        {
            return 'incorrect_character_in_city';
        }

        $avatar_file = "none";

        $arr = $db->query("
            UPDATE
                `users`
            SET
                `firstname` = '$firstname',
                `name` = '$name',
                `lastname` = '$lastname',
                `sex` = '$sex'
            WHERE
                id = $id
        ");

        $arr = $db->query("
            UPDATE
                `user_info`
            SET
                `status` = '$status',
                `date_of_birth` = '$date_of_birth',
                `city` = '$city',
                `about_me` = '$about_me'
            WHERE
                user_id = $id
        ");

        $arr = $db->query("
            UPDATE
                `user_settings`
            SET
                `avatar_file` = '$avatar_file'
            WHERE
                user_id = $id
        ");

        return 'access';
    }

    function update_user_privacy($id, $hide_lastname, $hide_email, $hide_phone, $hide_date_of_birth, $type_of_profile)
    {
        $arr = [];
        $db = new MysqlModel();

        $arr = $db->query("
            UPDATE
                `user_settings`
            SET
                `hide_lastname` = $hide_lastname,
                `hide_email` = $hide_email,
                `hide_phone` = $hide_phone,
                `hide_date_of_birth` = $hide_date_of_birth,
                `type_of_profile` = $type_of_profile
            WHERE
                user_id = $id
        ");

        return 'access';
    }

    function create_user_post($id, $text)
    {
        $arr = [];
        $db = new MysqlModel();

        if (!empty($text))
        {
            $arr = $db->query("
                INSERT INTO `posts`(
                    `id`,
                    `user_id`,
                    `group_id`,
                    `title`,
                    `description`,
                    `date_of_creation`,
                    `likes`
                )
                VALUES(
                    NULL,
                    '$id',
                    NULL,
                    NULL,
                    '$text',
                    CURRENT_TIMESTAMP,
                    0
                )
            ");
        }
    }

    function get_user_posts($id)
    {
        $arr = [];
        $db = new MysqlModel();

        $arr = $db->goResult("
            SELECT
                *
            FROM
                posts
            WHERE
                user_id = $id
        ");

        return $arr;
    }
?>