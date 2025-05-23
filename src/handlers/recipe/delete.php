<?php
// Подключаем конфигурацию и функции для подключения к БД
require_once dirname(__DIR__, 2) . '/db.php';

// Получаем id рецепта из GET-запроса (например: delete.php?id=5)
$id = $_GET['id'] ?? null;

/**
 * Удаление рецепта по ID.
 * Проверяется, что ID передан и является числом.
 * Затем выполняется SQL-запрос на удаление записи из таблицы recipes.
 */
if ($id && is_numeric($id)) { // Проверяем, что id существует и является числом
    try {
        // Получаем подключение к базе данных
        $pdo = getDbConnection();

        // Подготавливаем SQL-запрос на удаление рецепта
        $sql = "DELETE FROM recipes WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        // Выполняем запрос, передавая значение id в параметре
        $stmt->execute([':id' => $id]);

        // Проверяем, был ли удален хотя бы один рецепт
        if ($stmt->rowCount() > 0) {
            echo "Рецептa успешно удален!";
            // После успешного удаления перенаправляем на главную страницу
            header("Location: /index.php?page=index");
            exit;
        } else {
            echo "Ошибка при удалении рецепта.";
        }
    } catch (PDOException $e) {
        // Вывод сообщения об ошибке при сбое запроса
        echo "Ошибка: " . $e->getMessage();
    }
} else {
    // Если id не передан или некорректен
    echo "Неверный запрос. Не указан id рецепта.";
}
