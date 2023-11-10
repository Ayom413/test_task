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

// Обработка поискового запроса
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchText = $_POST['searchText'];

    // Поиск записей по комментариям
    $stmt = $pdo->prepare("SELECT posts.title, comments.body FROM posts JOIN comments ON posts.id = comments.postId WHERE comments.body LIKE :searchText");
    $stmt->execute(['searchText' => "%$searchText%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Вывод результатов
    if (count($results) > 0) {
        echo "<h2>Результаты поиска:</h2>";
        foreach ($results as $result) {
            echo "<p><strong>{$result['title']}</strong>: {$result['body']}</p>";
        }
    } else {
        echo "<p>Ничего не найдено.</p>";
    }
}