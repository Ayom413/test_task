<?php
$host = 'localhost';
$dbname = 'infostore';
$username = 'root';
$password = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

$postsJson = file_get_contents('https://jsonplaceholder.typicode.com/posts');
$posts = json_decode($postsJson, true);

foreach ($posts as $post) {
    $stmt = $pdo->prepare("INSERT INTO posts (id, userId, title, body) VALUES (?, ?, ?, ?)");
    $stmt->execute([$post['id'], $post['userId'], $post['title'], $post['body']]);
}

$commentsJson = file_get_contents('https://jsonplaceholder.typicode.com/comments');
$comments = json_decode($commentsJson, true);

foreach ($comments as $comment) {
    $stmt = $pdo->prepare("INSERT INTO comments (id, postId, name, email, body) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$comment['id'], $comment['postId'], $comment['name'], $comment['email'], $comment['body']]);
}

$postsCount = count($posts);
$commentsCount = count($comments);
echo "Загружено $postsCount записей и $commentsCount комментариев\n";
