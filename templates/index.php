<?php
// Подключение к базе данных
require_once __DIR__ . '/../src/db.php';

$recipesPerPage = 5; // Количество рецептов на странице

// Получаем текущую страницу из GET-параметра
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);
$offset = ($page - 1) * $recipesPerPage;

try {
    // Получаем подключение
    $pdo = getDbConnection();

    // Выполняем запрос для получения всех рецептов с учетом пагинации
    $stmt = $pdo->prepare("SELECT id, title FROM recipes ORDER BY id ASC LIMIT :limit OFFSET :offset");
    $stmt->bindParam(':limit', $recipesPerPage, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Получаем общее количество рецептов
    $totalRecipesStmt = $pdo->query("SELECT COUNT(*) FROM recipes");
    $totalRecipes = $totalRecipesStmt->fetchColumn();

    // Рассчитываем общее количество страниц
    $totalPages = ceil($totalRecipes / $recipesPerPage);

} catch (PDOException $e) {
    echo "Ошибка при подключении к базе данных: " . $e->getMessage();
    exit;
}
?>

<h2>Список рецептов</h2>

<ul>
    <?php foreach ($recipes as $recipe): ?>
        <li>
            <a href="/?page=show&id=<?= htmlspecialchars($recipe['id']) ?>">
                <?= htmlspecialchars($recipe['title']) ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="/?page=<?= $page - 1 ?>">Предыдущая</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="/?page=<?= $i ?>" <?= $i == $page ? 'class="active"' : '' ?>><?= $i ?></a>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
        <a href="/?page=<?= $page + 1 ?>">Следующая</a>
    <?php endif; ?>
</div>


