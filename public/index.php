<?php

// Подключаем конфигурацию и хелперы
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/helpers.php';

// Определяем текущую страницу из параметра запроса
$page = $_GET['page'] ?? 'index';

/**
 * Обработка запроса страницы редактирования рецепта.
 * Если задан параметр 'id', то производится попытка получить рецепт из базы.
 * В случае отсутствия id или рецепта выводится сообщение об ошибке.
 */
if ($page === 'edit_recipe') {
    require_once __DIR__ . '/../src/helpers.php';
    $id = $_GET['id'] ?? null;

    if ($id) {
        $recipe = getRecipeById($id);

        if (!$recipe) {
            echo "Рецепт не найден.";
            exit;
        }
    } else {
        echo "ID рецепта не указан.";
        exit;
    }
}

/**
 * Определение пути к файлу шаблона или обработчика в зависимости от значения $page.
 * Используется конструкция match для более чистой и наглядной логики выбора.
 */
$pagePath = match ($page) {
    'index' => __DIR__ . '/../templates/index.php',  // Страница главная
    'create' => __DIR__ . '/../templates/recipe/create.php',  // Страница создания рецепта (форма)
    'show' => __DIR__ . '/../templates/recipe/show.php',  // Страница просмотра рецепта
    'test' => __DIR__ . '/../src/test.php',  // Вспомогательная тестовая страница
    'create_recipe' => __DIR__ . '/../src/handlers/recipe/create.php',  // Обработчик POST-запроса создания рецепта
    'edit_recipe' => __DIR__ . '/../templates/recipe/edit.php', // Форма редактирования рецепта
    'edit_recipe_handler' => __DIR__ . '/../src/handlers/recipe/edit.php', // Обработка POST-запроса редактирования
    'delete_recipe' => __DIR__ . '/../src/handlers/recipe/delete.php', // Обработчик удаления рецепта
    default => __DIR__ . '/../templates/index.php',  // По умолчанию главная страница
};

/**
 * Подключение базового шаблона страницы.
 * Внутри шаблона используется переменная $pagePath для вставки соответствующего контента.
 */
require_once __DIR__ . '/../templates/layout.php';
