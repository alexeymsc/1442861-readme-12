<?php
require(__DIR__.'/bootstrap.php');



$sql_types = 'select type,icon from content_type';
$types = $db->query($sql_types)->fetch_all(MYSQLI_ASSOC);

$chosen_type = $_GET['content_type'] ?? "";

if (!in_array($chosen_type, array_column($types, 'type'), true) and $chosen_type) {
    call_404("Посты с типом '".$chosen_type."' не найдены",$user_name,$is_auth);
};

$sql_posts = 'SELECT post.id,post.date_created, header, type, 
    content_text,cite_author,content_media,views, avatar,username, 
    COUNT(distinct comment.content) as comments_number,COUNT(like_post.id) as likes
        FROM post  
        JOIN user ON user_id = user.id 
        JOIN content_type ON content_type_id = content_type.id
        LEFT JOIN comment on post.id = comment.post_id
        LEFT JOIN like_post on post.id = like_post.post_id
        where type = ? OR ?=""
        GROUP BY (post.id)
        ORDER BY views DESC LIMIT 6';
$posts = prepare_statement($db, $sql_posts, [$chosen_type, $chosen_type])->get_result()->fetch_all(MYSQLI_ASSOC);


$content = include_template('main.php', ['posts' => $posts, 'types' => $types, 'chosen_type' => $chosen_type,]);




$page = include_template('layout.php', ['content' => $content, 'page_name' => 'Главная страница','is_auth' => $is_auth, 'user_name' =>$user_name,]);

print($page);
