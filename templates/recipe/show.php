<?php
// Подключение к базе данных
require_once __DIR__ . '/../../src/db.php';

// Получаем ID рецепта из параметров запроса
$id = $_GET['id'] ?? null;

if (!$id) {
    // Проверка: если ID не передан, выводим сообщение и прекращаем выполнение
    echo "ID рецепта не указан.";
    return;
}

try {
    // Устанавливаем подключение к БД
    $pdo = getDbConnection();

    // Получаем данные рецепта по ID
    $stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$recipe) {
        // Проверка: если рецепт не найден, сообщаем и завершаем выполнение
        echo "Рецепт не найден.";
        return;
    }

    // Получаем название категории по ID из таблицы категорий
    $categoryStmt = $pdo->prepare("SELECT name FROM categories WHERE id = :id");
    $categoryStmt->execute([':id' => $recipe['category']]);
    $category = $categoryStmt->fetchColumn();

    // Экранируем текстовые поля рецепта и название категории
    // Это предотвращает XSS-атаки при выводе данных в HTML
    $recipe['title'] = htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8');
    $recipe['ingredients'] = htmlspecialchars($recipe['ingredients'], ENT_QUOTES, 'UTF-8');
    $recipe['description'] = htmlspecialchars($recipe['description'], ENT_QUOTES, 'UTF-8');
    $recipe['steps'] = htmlspecialchars($recipe['steps'], ENT_QUOTES, 'UTF-8');
    $category = htmlspecialchars($category, ENT_QUOTES, 'UTF-8');

} catch (PDOException $e) {
    // Обработка ошибок при работе с базой данных
    echo "Ошибка: " . $e->getMessage();
    return;
}

?>


<h2><?= htmlspecialchars($recipe['title']) ?></h2>
<p><strong>Категория:</strong> <?= htmlspecialchars($category ?? 'Не указана') ?></p>
<p><strong>Описание:</strong> <?= nl2br(htmlspecialchars($recipe['description'])) ?></p>
<p><strong>Ингредиенты:</strong> <?= nl2br(htmlspecialchars($recipe['ingredients'])) ?></p>
<p><strong>Шаги:</strong> <?= nl2br(htmlspecialchars($recipe['steps'])) ?></p>
<p><strong>Теги:</strong> <?= htmlspecialchars($recipe['tags']) ?></p>

<p>
    <a href="/index.php?page=edit_recipe&id=<?= $recipe['id'] ?>">Редактировать</a> |
    <a href="/index.php?page=delete_recipe&id=<?= $recipe['id'] ?>" onclick="return confirm('Вы уверены, что хотите удалить этот рецепт?');">Удалить</a>
</p>
