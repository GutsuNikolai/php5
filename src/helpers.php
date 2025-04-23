<?php
/**
 * Получает рецепт из базы данных по его ID.
 *
 * @param int $id ID рецепта, который нужно найти.
 * @return array|null Ассоциативный массив с данными рецепта, если найден; null — если не найден.
 */
function getRecipeById($id): ?array {
    require_once __DIR__ . '/db.php'; // Подключаем файл конфигурации для подключения к БД

    $pdo = getDbConnection();

    $stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = :id");
    $stmt->execute(['id' => $id]);

    $recipe = $stmt->fetch(PDO::FETCH_ASSOC);
    return $recipe ?: null;
}

