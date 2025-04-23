<?php


// Подключаем конфигурацию и хелперы
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/helpers.php';

// Определяем текущую страницу
$page = $_GET['page'] ?? 'index';

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
// Определяем путь до обработчика или шаблона
$pagePath = match ($page) {
    'index' => __DIR__ . '/../templates/index.php',  // Страница главная
    'create' => __DIR__ . '/../templates/recipe/create.php',  // Страница для создания рецепта (форма)
    'show' => __DIR__ . '/../templates/recipe/show.php',  // Страница для отображения рецепта
    'test' => __DIR__ . '/../src/test.php',  // Пример теста
    'create_recipe' => __DIR__ . '/../src/handlers/recipe/create.php',  // Обработчик для создания рецепта
    'edit_recipe' => __DIR__ . '/../templates/recipe/edit.php', // <-- это теперь форма
    'edit_recipe_handler' => __DIR__ . '/../src/handlers/recipe/edit.php', // <-- это обработка POST
    'delete_recipe' => __DIR__ . '/../src/handlers/recipe/delete.php', // Обработчик для удаления рецепта
    default => __DIR__ . '/../templates/index.php',  // По умолчанию главная страница
};


// Подключаем базовый шаблон, в который будет "встроена" страница
require_once __DIR__ . '/../templates/layout.php';
