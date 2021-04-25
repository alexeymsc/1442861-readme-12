<?php
require(__DIR__.'/bootstrap.php');

$sql_types = 'select type,icon from content_type';
$types = $db->query($sql_types)->fetch_all(MYSQLI_ASSOC);

$chosen_type = $_GET['content_type'] ?? "post-quote";

$content = include_template('add-template.php', ['types' => $types, 'chosen_type' => $chosen_type,]);



$page = include_template('layout.php', ['content' => $content, 'page_name' => 'Главная страница','is_auth' => $is_auth, 'user_name' =>$user_name,]);

print($page);