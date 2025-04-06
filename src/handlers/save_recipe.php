<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Подключаем вспомогательные функции
include_once('../helpers.php');

// Массив для ошибок
$errors = [];



// Обработка данных формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipeFile = '../../storage/recipes.txt';
    // Фильтруем входные данные
    $title = filterData($_POST['title']);
    $category = filterData($_POST['category']);
    $ingredients = filterData($_POST['ingredients']);
    $description = filterData($_POST['description']);
    $steps = $_POST['steps'];
    $tags = $_POST['tags'];

    // Валидация данных
    if (empty($title)) {
        $errors['title'] = 'Название рецепта обязательно!';
    }
    if (empty($category)) {
        $errors['category'] = 'Категория рецепта обязательна!';
    }
    if (empty($ingredients)) {
        $errors['ingredients'] = 'Ингредиенты обязательны!';
    }
    if (empty($description)) {
        $errors['description'] = 'Описание рецепта обязательно!';
    }
    if (empty($steps)) {
        $errors['steps'] = 'Шаги приготовления обязательны!';
    }

    // Если нет ошибок, сохраняем данные
    // Проверка данных перед записью

    if (empty($errors)) {
        // Формируем данные для записи
        $formData = [
            'title' => $title,
            'category' => $category,
            'ingredients' => $ingredients,
            'description' => $description,
            'steps' => $steps,
            'tags' => $tags
        ];

    
        
        $recipeFile = '../../storage/recipes.txt';

        $existingData = file_exists($recipeFile) ? json_decode(file_get_contents($recipeFile), true) : [];

        // Добавляем новый рецепт
        $existingData[] = $formData;


        // Сохраняем данные в файл
        if (file_put_contents($recipeFile, json_encode($existingData, JSON_PRETTY_PRINT) . PHP_EOL)) {
            // Перенаправляем на главную страницу
            header("Location: /public/index.php");
            exit;
        } else {
            $errors['general'] = 'Ошибка при сохранении рецепта.';
        }
    }
}
?>

