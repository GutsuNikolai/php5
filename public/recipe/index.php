<?php
/**
 * Количество рецептов на странице
 *
 * @var int
 */
$recipesPerPage = 5;

/**
 * Путь к файлу с рецептами
 *
 * @var string
 */
$recipeFile = '../../storage/recipes.txt';

/**
 * Массив для хранения рецептов
 *
 * @var array
 */
$recipes = [];

/**
 * Проверяем, существует ли файл с рецептами
 * Если файл существует, читаем данные, иначе выводим сообщение об ошибке
 */
if (file_exists($recipeFile)) {
    /**
     * Прочитаем все строки из файла
     *
     * @var array
     */
    $fileContents = file($recipeFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    /**
     * Проходим по всем строкам файла
     * Каждая строка содержит один рецепт в формате JSON
     */
    foreach ($fileContents as $line) {
        // Декодируем JSON из каждой строки
        $recipe = json_decode($line, true);
        
        // Проверим на ошибки при декодировании
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo 'Ошибка при декодировании JSON: ' . json_last_error_msg();
        } else {
            // Добавляем рецепт в массив
            $recipes[] = $recipe;
        }
    }
} else {
    echo 'Файл не существует.<br>';
    $recipes = [];
}

/**
 * Проверка, если рецепты не были загружены, выводим ошибку
 */
if ($recipes === null) {
    echo 'Ошибка при чтении данных из файла';
    $recipes = [];
}

/**
 * Если $recipes не является массивом, присваиваем пустой массив
 */
if (!is_array($recipes)) {
    $recipes = [];
}

/**
 * Общее количество рецептов
 *
 * @var int
 */
$totalRecipes = count($recipes);

/**
 * Общее количество страниц, основанное на количестве рецептов и рецептов на странице
 *
 * @var int
 */
$totalPages = ceil($totalRecipes / $recipesPerPage);

/**
 * Получаем номер текущей страницы, по умолчанию 1
 *
 * @var int
 */
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

/**
 * Индекс первого рецепта для текущей страницы
 *
 * @var int
 */
$start = ($page - 1) * $recipesPerPage;

/**
 * Рецепты для текущей страницы
 *
 * @var array
 */
$currentPageRecipes = array_slice($recipes, $start, $recipesPerPage); // Рецепты для текущей страницы

/**
 * Отображение списка рецептов
 */
echo '<h1>Список рецептов</h1>';
if (empty($currentPageRecipes)) {
    echo 'Нет рецептов.';
} else {
    echo '<ul>';
    foreach ($currentPageRecipes as $recipe) {
        echo '<li>';
        echo '<h3>' . htmlspecialchars($recipe['title']) . '</h3>';
        echo '<p>Категория: ' . htmlspecialchars($recipe['category']) . '</p>';
        echo '<p>Ингредиенты: ' . htmlspecialchars($recipe['ingredients']) . '</p>';
        echo '<p>Описание: ' . htmlspecialchars($recipe['description']) . '</p>';
        echo '<p>Шаги: ' . implode(', ', $recipe['steps']) . '</p>';
        echo '</li>';
    }
    echo '</ul>';
}

/**
 * Навигация по страницам
 */
echo '<nav>';
echo '<ul class="pagination">';

/**
 * Вывод ссылки на предыдущую страницу, если она существует
 */
if ($page > 1) {
    echo '<li><a href="?page=' . ($page - 1) . '">« Предыдущая</a></li>';
}

/**
 * Ссылки на страницы пагинации
 */
for ($i = 1; $i <= $totalPages; $i++) {
    echo '<a href="?page='. $i . '">' . $i . '  </a>';
}

/**
 * Вывод ссылки на следующую страницу, если она существует
 */
if ($page < $totalPages) {
    echo '<li><a href="?page=' . ($page + 1) . '">Следующая »</a></li>';
}

echo '</ul>';
echo '</nav>';

?>
