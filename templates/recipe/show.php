<?php
require_once __DIR__ . '/../../src/db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID рецепта не указан.";
    return;
}

try {
    $pdo = getDbConnection();

    // Получаем рецепт
    $stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$recipe) {
        echo "Рецепт не найден.";
        return;
    }

    // Получаем название категории
    $categoryStmt = $pdo->prepare("SELECT name FROM categories WHERE id = :id");
    $categoryStmt->execute([':id' => $recipe['category']]);
    $category = $categoryStmt->fetchColumn();
    
    // Экранируем данные для вывода в HTML
    $recipe['title'] = htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8');
    $recipe['ingredients'] = htmlspecialchars($recipe['ingredients'], ENT_QUOTES, 'UTF-8');
    $recipe['description'] = htmlspecialchars($recipe['description'], ENT_QUOTES, 'UTF-8');
    $recipe['steps'] = htmlspecialchars($recipe['steps'], ENT_QUOTES, 'UTF-8');
    $category = htmlspecialchars($category, ENT_QUOTES, 'UTF-8');

} catch (PDOException $e) {
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
