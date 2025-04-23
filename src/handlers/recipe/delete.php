<?php
// Подключаем конфигурацию и функции для работы с БД
require_once dirname(__DIR__, 2) . '/db.php';

// Получаем id рецепта из GET-запроса
$id = $_GET['id'] ?? null;

if ($id && is_numeric($id)) { // Проверяем, что id существует и является числом
    try {
        // Получаем подключение к базе данных
        $pdo = getDbConnection();

        // Запрос на удаление рецепта
        $sql = "DELETE FROM recipes WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        // Выполняем запрос с привязанным параметром
        $stmt->execute([':id' => $id]);

        if ($stmt->rowCount() > 0) { // Проверяем, был ли удален хотя бы один рецепт
            echo "Рецепт успешно удален!";
            // После удаления перенаправляем на страницу списка рецептов
            header("Location: /index.php?page=index");
            exit;
        } else {
            echo "Ошибка при удалении рецепта.";
        }
    } catch (PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
} else {
    echo "Неверный запрос. Не указан id рецепта.";
}
?>
