<?php
/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
 *
 * Примеры использования:
 * is_date_valid('2019-01-01'); // true
 * is_date_valid('2016-02-29'); // true
 * is_date_valid('2019-04-31'); // false
 * is_date_valid('10.10.2010'); // false
 * is_date_valid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function is_date_valid(string $date): bool
{
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *  
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = [])
{
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            } else {
                if (is_string($value)) {
                    $type = 's';
                } else {
                    if (is_double($value)) {
                        $type = 'd';
                    }
                }
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}

/**
 * Возвращает корректную форму множественного числа
 * Ограничения: только для целых чисел
 *
 * Пример использования:
 * $remaining_minutes = 5;
 * echo "Я поставил таймер на {$remaining_minutes} " .
 *     get_noun_plural_form(
 *         $remaining_minutes,
 *         'минута',
 *         'минуты',
 *         'минут'
 *     );
 * Результат: "Я поставил таймер на 5 минут"
 *
 * @param int $number Число, по которому вычисляем форму множественного числа
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 * @param string $many Форма множественного числа для остальных чисел
 *
 * @return string Рассчитанная форма множественнго числа
 */
function get_noun_plural_form(int $number, string $one, string $two, string $many): string
{
    $number = (int)$number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template($name, array $data = [])
{
    $name = __DIR__.'/templates/' . $name;
    $result = '';

    ob_start();
    extract($data); 
    require $name;

    $result = ob_get_clean();

    return $result;
}

/**
 * Функция проверяет доступно ли видео по ссылке на youtube
 * @param string $url ссылка на видео
 *
 * @return string Ошибку если валидация не прошла
 */
function check_youtube_url($url)
{
    $id = extract_youtube_id($url);

    set_error_handler(function () {}, E_WARNING);
    $headers = get_headers('https://www.youtube.com/oembed?format=json&url=http://www.youtube.com/watch?v=' . $id);
    restore_error_handler();

    if (!is_array($headers)) {
        return "Видео по такой ссылке не найдено. Проверьте ссылку на видео";
    }

    $err_flag = strpos($headers[0], '200') ? 200 : 404;

    if ($err_flag !== 200) {
        return "Видео по такой ссылке не найдено. Проверьте ссылку на видео";
    }

    return true;
}

/**
 * Возвращает код iframe для вставки youtube видео на страницу
 * @param string $youtube_url Ссылка на youtube видео
 * @return string
 */
function embed_youtube_video($youtube_url)
{
    $res = "";
    $id = extract_youtube_id($youtube_url);

    if ($id) {
        $src = "https://www.youtube.com/embed/" . $id;
        $res = '<iframe width="760" height="400" src="' . $src . '" frameborder="0"></iframe>';
    }

    return $res;
}

/**
 * Возвращает img-тег с обложкой видео для вставки на страницу
 * @param string $youtube_url Ссылка на youtube видео
 * @return string
 */
function embed_youtube_cover($youtube_url)
{
    $res = "";
    $id = extract_youtube_id($youtube_url);

    if ($id) {
        $src = sprintf("https://img.youtube.com/vi/%s/mqdefault.jpg", $id);
        $res = '<img alt="youtube cover" width="320" height="120" src="' . $src . '" />';
    }

    return $res;
}

/**
 * Извлекает из ссылки на youtube видео его уникальный ID
 * @param string $youtube_url Ссылка на youtube видео
 * @return array
 */
function extract_youtube_id($youtube_url)
{
    $id = false;

    $parts = parse_url($youtube_url);

    if ($parts) {
        if ($parts['path'] == '/watch') {
            parse_str($parts['query'], $vars);
            $id = $vars['v'] ?? null;
        } else {
            if ($parts['host'] == 'youtu.be') {
                $id = substr($parts['path'], 1);
            }
        }
    }

    return $id;
}

/**
 * @param $index
 * @return false|string
 */
function generate_random_date($index)
{
    $deltas = [['minutes' => 59], ['hours' => 23], ['days' => 6], ['weeks' => 4], ['months' => 11]];
    $dcnt = count($deltas);

    if ($index < 0) {
        $index = 0;
    }

    if ($index >= $dcnt) {
        $index = $dcnt - 1;
    }

    $delta = $deltas[$index];
    $timeval = rand(1, current($delta));
    $timename = key($delta);

    $ts = strtotime("$timeval $timename ago");
    $dt = date('Y-m-d H:i:s', $ts);

    return $dt;
}


/**
 * @param string $long_content Строка, которую нужно сократить
 * @param int $max_length Максимальная длина строки
 * @return string Возвращает укороченный вариант строки, если длина превышает максимальную
 */

function cutContent(string $long_content, int $max_length = 300): string
{

    if (mb_strlen($long_content) <= $max_length) {
        return $long_content;
    }
    $long_content = explode(' ', $long_content);
    $current_length = 0;
    $counter = 0;

    while ($current_length <= $max_length) {
        $word = $long_content[$counter++];
        $current_length += (mb_strlen($word) + 1);
    }
    return implode(' ', array_slice($long_content, 0, $counter - 1)) . '...';
}

function s($input)
{
    return htmlspecialchars($input, ENT_QUOTES, null, false);
}


function time_ago ($val_date)
{
    $cur_date = date_create('now');
    $sub_date = date_create($val_date);
    $diff = date_diff($cur_date, $sub_date);

    if ($diff->y >0) {
        $unit = $diff->y;
        $noun = get_noun_plural_form($unit, 'год', 'года', 'лет');
    } elseif ($diff->m >0) {
        $unit = $diff->m;
        $noun = get_noun_plural_form($unit, 'месяц', 'месяца', 'месяцев');    
    } elseif ($diff->d > 7) {
        $unit = intdiv($diff->days, 7);
        $noun = get_noun_plural_form($unit, 'неделя', 'недели', 'недель');
    } elseif ($diff->d > 0) {
        $unit = $diff->d;
        $noun = get_noun_plural_form($unit, 'день', 'дня', 'дней');
    } elseif ($diff->h >0) {
        $unit = $diff->h;
        $noun = get_noun_plural_form($unit, 'час', 'часа', 'часов');
    } else {
        $unit = $diff->i;
        $noun = get_noun_plural_form($unit, 'минута', 'минуты', 'минут');
    }
    return $unit." ".$noun;
       
}

/**
 * @param mysqli $db БД MySQL, к которой будет направлен запрос
 * @param string $sql_query Подготовленное выражение-запрос 
 * @param array $placeholders Массив плейсхолдеров для вставки в запрос
 * @return mysqli_stmt Возвращает результат исполнения подготовленного выражения
 */

function prepare_statement(mysqli $db, string $sql_query,array $placeholders): mysqli_stmt
{
    $stmt = $db->prepare($sql_query);
    $phds_count = count($placeholders);

    $stmt->bind_param(str_repeat('s', $phds_count), ...$placeholders);
    $stmt->execute();

    return $stmt;
}

/**
 * Выводит сообщение об ошибке запроса в теле страницы и останавливает сценарий 
 * @param $message сообщение об ошибке, идентифицирующее неправильный запрос
 * @param $wrong_var переменная, которая указана некорректно 
 * @param $user_name имя пользователя для шапки страницы
 */

function call_404 ($message,$user_name,$is_auth)  {

    http_response_code(404);
    $content = include_template('404.php', ['false_request' => $message,]);
    $page = include_template('layout.php', ['content' => $content, 'page_name' => 'УПС','is_auth' => $is_auth, 'user_name' =>$user_name,]);
    die ($page);
}