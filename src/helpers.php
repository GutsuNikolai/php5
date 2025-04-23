<?php
function getRecipeById($id): ?array {
    require_once __DIR__ . '/db.php'; // если db.php находится в той же папке (src/)


    $pdo = getDbConnection();

    $stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = :id");
    $stmt->execute(['id' => $id]);

    $recipe = $stmt->fetch(PDO::FETCH_ASSOC);
    return $recipe ?: null;
}
