<?php
$recipeFile = '../storage/recipes.txt';
$recipes = file_exists($recipeFile) ? json_decode(file_get_contents($recipeFile), true) : [];

echo '<h1>Список рецептов</h1>';
if (empty($recipes)) {
    echo 'Нет рецептов.';
} else {
    echo '<ul>';
    foreach ($recipes as $recipe) {
        echo '<li>' . htmlspecialchars($recipe['title']) . ' - ' . htmlspecialchars($recipe['category']) . '</li>';
    }
    echo '</ul>';
}
?>
