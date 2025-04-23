<?php

require_once dirname(__DIR__, 2) . '/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем ID рецепта
    $id = $_POST['id'] ?? null;

    // Получаем данные из формы
    $title = trim($_POST['title'] ?? '');
    $category = $_POST['category'] ?? '';
    $ingredients = trim($_POST['ingredients'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $steps = trim($_POST['steps'] ?? '');
    $tags = trim($_POST['tags'] ?? '');

    // Простая валидация
    if (empty($id) || empty($title) || empty($category) || empty($ingredients) || empty($description) || empty($steps)) {
        echo "Пожалуйста, заполните все обязательные поля.";
        exit;
    }
    
    // Экранируем данные для защиты от XSS
    $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $ingredients = htmlspecialchars($ingredients, ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
    $steps = htmlspecialchars($steps, ENT_QUOTES, 'UTF-8');
    $tags = htmlspecialchars($tags, ENT_QUOTES, 'UTF-8');
    $category = htmlspecialchars($category, ENT_QUOTES, 'UTF-8');
    
    // SQL-запрос на обновление
    $sql = "UPDATE recipes 
            SET title = :title, 
                category = :category, 
                ingredients = :ingredients, 
                description = :description, 
                steps = :steps, 
                tags = :tags 
            WHERE id = :id";

    try {
        $pdo = getDbConnection();

        $stmt = $pdo->prepare($sql);
        $success = $stmt->execute([
            ':title' => $title,
            ':category' => $category,
            ':ingredients' => $ingredients,
            ':description' => $description,
            ':steps' => $steps,
            ':tags' => $tags,
            ':id' => $id
        ]);

        if ($success) {
            header("Location: /index.php?page=show&id=$id");
            exit;
        } else {
            echo "Не удалось обновить рецепт.";
        }

    } catch (PDOException $e) {
        echo "Ошибка при работе с базой данных: " . $e->getMessage();
    }

} else {
    echo "Неверный метод запроса.";
}
