<?php
$recipeFile = '../storage/recipes.txt';

$recipes = file($recipeFile, FILE_IGNORE_NEW_LINES);
$recipes = array_map(function ($line) {
    return json_decode($line, true); // <-- теперь это массив
}, $recipes);
$latestRecipes = array_slice($recipes, -2);

// Отображение
echo '<h1>Последние рецепты</h1>';
if (empty($latestRecipes)) {
    echo 'Нет рецептов.';
} else {
    foreach ($latestRecipes as $recipe) {
        echo '<h2>' . htmlspecialchars($recipe['title']) . '</h2>';
        echo '<p><strong>Категория:</strong> ' . htmlspecialchars($recipe['category']) . '</p>';
        echo '<p><strong>Ингредиенты:</strong> ' . htmlspecialchars($recipe['ingredients']) . '</p>';
        echo '<p><strong>Описание:</strong> ' . htmlspecialchars($recipe['description']) . '</p>';
        
        echo '<p><strong>Шаги:</strong></p>';
        echo '<ul>';
        foreach ($recipe['steps'] as $step) {
            echo '<li>' . htmlspecialchars($step) . '</li>';
        }
        echo '</ul>';
        
        echo '<p><strong>Теги:</strong> ' . implode(', ', array_map('htmlspecialchars', $recipe['tags'])) . '</p>';
    }
}
?>
