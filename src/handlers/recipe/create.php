<?php
echo 'Файл create.php был открыт<br>';

require_once dirname(__DIR__, 2) . '/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title'] ?? '');
    $categoryName = trim($_POST['category'] ?? '');
    $ingredients = trim($_POST['ingredients'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $steps = trim($_POST['steps'] ?? '');
    $tags = trim($_POST['tags'] ?? '');

    if (empty($title) || empty($categoryName) || empty($ingredients) || empty($description) || empty($steps)) {
        echo "Пожалуйста, заполните все поля!";
        exit;
    }
    // Экранирование данных перед вставкой в БД (защита от XSS)
    $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $ingredients = htmlspecialchars($ingredients, ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
    $steps = htmlspecialchars($steps, ENT_QUOTES, 'UTF-8');
    $tags = htmlspecialchars($tags, ENT_QUOTES, 'UTF-8');
    $categoryName = htmlspecialchars($categoryName, ENT_QUOTES, 'UTF-8');

    // Проверка категории (необходимо целое число)
    $categoryName = filter_var($categoryName, FILTER_SANITIZE_SPECIAL_CHARS);

    // Дополнительная валидация на пустое значение или нежелательные символы
    if (empty($categoryName) || strlen($categoryName) < 1) {
        echo "Некорректное имя категории! Поле не должно быть пустым";
        exit;
    }

    try {
        $pdo = getDbConnection();

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

        $sql = "INSERT INTO recipes (title, category, ingredients, description, steps, tags) 
                VALUES (:title, :category, :ingredients, :description, :steps, :tags)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':category', $categoryId, PDO::PARAM_INT);
        $stmt->bindParam(':ingredients', $ingredients);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':steps', $steps);
        $stmt->bindParam(':tags', $tags);

        if ($stmt->execute()) {
            echo "Рецепт успешно добавлен!";
        } else {
            echo "Ошибка при добавлении рецепта.";
        }
    } catch (PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}
