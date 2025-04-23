<h2>Редактировать рецепт</h2>

<form method="POST" action="/index.php?page=edit_recipe_handler">
  <input type="hidden" name="id" value="<?= $recipe['id'] ?>">

    <label for="title">Название рецепта:</label><br>
    <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($recipe['title']); ?>" required><br><br>

    <label for="category">Категория:</label><br>
    <input type="text" name="category" id="category" value="<?php echo htmlspecialchars($recipe['category']); ?>" required><br><br>

    <label for="ingredients">Ингредиенты:</label><br>
    <textarea name="ingredients" id="ingredients" rows="3" required><?php echo htmlspecialchars($recipe['ingredients']); ?></textarea><br><br>

    <label for="description">Описание:</label><br>
    <textarea name="description" id="description" rows="3"><?php echo htmlspecialchars($recipe['description']); ?></textarea><br><br>

    <label for="tags">Теги:</label><br>
    <input type="text" name="tags" id="tags" value="<?php echo htmlspecialchars($recipe['tags']); ?>"><br><br>

    <label for="steps">Шаги:</label><br>
    <textarea name="steps" id="steps" rows="5"><?php echo htmlspecialchars($recipe['steps']); ?></textarea><br><br>

    <button type="submit">Сохранить изменения</button>
</form>
