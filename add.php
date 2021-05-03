<?php
require(__DIR__ . '/bootstrap.php');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required = array(
        'photo' => ['photo-heading', 'filepath'],
        'video' => ['video-heading', 'video-url',],
        'text' => ['text-heading', 'post-text',],
        'quote' => ['quote-heading', 'cite-text', 'quote-author',],
        'link' => ['link-heading', 'post-link',]
    );

    $fields = array(
        'photo' => ['photo-heading', 'photo-url', 'photo-tags', 'userpic-file-photo'],
        'video' => ['video-heading', 'video-url', 'video-tags',],
        'text' => ['text-heading', 'post-text', 'post-tags'],
        'quote' => ['quote-heading', 'cite-text', 'quote-author', 'quote-tags',],
        'link' => ['link-heading', 'post-link',]
    );


    $content_type = $_POST['content-type'] ?? "";


    $requested = filter_input_array(INPUT_POST, array_fill_keys($fields[$content_type], 'FILTER_DEFAULT'), true);
    $required_types = ['image/png', 'image/gif', 'image/jpeg',];

    $rules = [
        'filepath' => function ($value) use ($required_types) {
            return validateMime($value, $required_types);
        }

    ];

    $errors = [];

    if ($content_type === 'photo' && !empty($_FILES['userpic-file-photo']['name'])) {
        $tmp_path = $_FILES['userpic-file-photo']['tmp_name'];
        $requested['filepath'] = file_get_contents($tmp_path);
        
    } elseif ($content_type === 'photo') {
        $requested['filepath'] = file_get_contents($requested['photo-url']);

    };

    foreach ($requested as $key => $value) {
        if (in_array($key, $required[$content_type]) && empty($value)) {
            $errors[$key] = "Поле $key надо заполнить";
        };

        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key]=$rule($value);
        }
    };
};


$errors = array_filter($errors);

$content = include_template('add-template.php', ['errors' => $errors, 'content_type' => $content_type]);

$page = include_template('layout.php', ['content' => $content, 'page_name' => 'Главная страница', 'is_auth' => $is_auth, 'user_name' => $user_name,]);

print($page);

