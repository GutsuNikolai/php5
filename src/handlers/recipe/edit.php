<?php
require_once dirname(__DIR__, 2) . '/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $pdo = getDbConnection(); // ← подключение БД СРАЗУ

    $id = $_POST['id'] ?? null;
    $title = trim($_POST['title'] ?? '');
    $categoryName = trim($_POST['category'] ?? '');
    $ingredients = trim($_POST['ingredients'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $steps = trim($_POST['steps'] ?? '');
    $tags = trim($_POST['tags'] ?? '');
    
    // Простая валидация обязателфьных полей
    if (empty($id) || empty($title) || empty($categoryName) || empty($ingredients) || empty($description) || empty($steps)) {
        echo "Пожалуйста, заполните все обязательные поля.";
        exit;
    }
    // Экранируем данные для защиты от XSS
    $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $ingredients = htmlspecialchars($ingredients, ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
    $steps = htmlspecialchars($steps, ENT_QUOTES, 'UTF-8');
    $tags = htmlspecialchars($tags, ENT_QUOTES, 'UTF-8');
    $categoryName = htmlspecialchars($categoryName, ENT_QUOTES, 'UTF-8');

    // Получение/создание категории
    $stmt = $pdo->prepare("SELECT id FROM categories WHERE name = :name");
    $stmt->execute([':name' => $categoryName]);
    $category = $stmt->fetch();
    if ($category) {
        $categoryId = $category['id'];
    } else {
        $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (:name)");
        $stmt->execute([':name' => $categoryName]);
        $categoryId = $pdo->lastInsertId();
    }

    // SQL-запрос на обновление рецепта
    $sql = "UPDATE recipes 
            SET title = :title, 
                category = :category, 
                ingredients = :ingredients, 
                description = :description, 
                steps = :steps, 
                tags = :tags 
            WHERE id = :id";

    try {
        // Подготавливаем и выполняем SQL-запрос
        $stmt = $pdo->prepare($sql);
        $success = $stmt->execute([
            ':title' => $title,
            ':category' => $categoryId,
            ':ingredients' => $ingredients,
            ':description' => $description,
            ':steps' => $steps,
            ':tags' => $tags,
            ':id' => $id
        ]);

        if ($success) {
            // Перенаправление на страницу рецепта после успешного обновления
            header("Location: /index.php?page=show&id=$id");
            exit;
        } else {
            
            echo "Не удалось обновить рецепт.";
        }

    } catch (PDOException $e) {
        echo "Ошибка при работе с базой данных: " . $e->getMessage();
    }
}
