<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить рецепт</title>
    <script>
        // Функция для добавления нового шага
        function addStep() {
            const stepsContainer = document.getElementById('steps-container');
            const stepCount = stepsContainer.children.length + 1;

            const newStep = document.createElement('div');
            newStep.innerHTML = `
                <label>Шаг ${stepCount}:</label><br>
                <input type="text" name="steps[]" required><br><br>
            `;

            stepsContainer.appendChild(newStep);
        }
    </script>
</head>
<body>
    <h1>Добавить рецепт</h1>
    <form action="/src/handlers/save_recipe.php" method="POST">
        <label for="title">Название рецепта:</label><br>
        <input type="text" id="title" name="title" required>
        <?php if (isset($errors['title'])): ?>
            <p style="color: red;"><?= $errors['title'] ?></p>
        <?php endif; ?><br><br>

        <label for="category">Категория:</label><br>
        <select id="category" name="category" required>
            <option value="Завтрак">Завтрак</option>
            <option value="Обед">Обед</option>
            <option value="Ужин">Ужин</option>
            <option value="Десерт">Десерт</option>
        </select>
        <?php if (isset($errors['category'])): ?>
            <p style="color: red;"><?= $errors['category'] ?></p>
        <?php endif; ?><br><br>

        <label for="ingredients">Ингредиенты:</label><br>
        <textarea id="ingredients" name="ingredients" rows="4" required></textarea>
        <?php if (isset($errors['ingredients'])): ?>
            <p style="color: red;"><?= $errors['ingredients'] ?></p>
        <?php endif; ?><br><br>

        <label for="description">Описание рецепта:</label><br>
        <textarea id="description" name="description" rows="6" required></textarea>
        <?php if (isset($errors['description'])): ?>
            <p style="color: red;"><?= $errors['description'] ?></p>
        <?php endif; ?><br><br>

        <label>Шаги приготовления:</label><br>
        <div id="steps-container">
            <div>
                <label>Шаг 1:</label><br>
                <input type="text" name="steps[]" required><br><br>
            </div>
        </div>
        <button type="button" onclick="addStep()">Добавить шаг</button>
        <?php if (isset($errors['steps'])): ?>
            <p style="color: red;"><?= $errors['steps'] ?></p>
        <?php endif; ?><br><br>

        <label for="tags">Тэги:</label><br>
        <select id="tags" name="tags[]" multiple size="4">
            <option value="Быстро">Быстро</option>
            <option value="Полезно">Полезно</option>
            <option value="Пикантно">Пикантно</option>
            <option value="Вегетарианское">Вегетарианское</option>
        </select><br><br>

        <button type="submit">Отправить</button>
    </form>
</body>
</html>
