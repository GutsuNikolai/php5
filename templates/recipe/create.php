<!-- templates/recipe/create.php -->

<h2>Добавить рецепт</h2>

<form action="/index.php?page=create_recipe" method="post">
    <label for="title">Название рецепта:</label><br>
    <input type="text" name="title" id="title" required><br><br>

    <label for="category">Категория:</label><br>
    <input type="text" name="category" id="category" required><br><br>

    <label for="ingredients">Ингредиенты (через запятую):</label><br>
    <textarea name="ingredients" id="ingredients" rows="3" required></textarea><br><br>

    <label for="description">Краткое описание:</label><br>
    <textarea name="description" id="description" rows="3" required></textarea><br><br>
    
    <label for="tags">Теги (через запятую):</label><br>
    <input type="text" name="tags" id="tags"><br><br>

    <label for="steps">Шаги (каждый шаг с новой строки):</label><br>
    <textarea name="steps" id="steps" rows="5" required></textarea><br><br>

    <button type="submit">Сохранить</button>
</form>
