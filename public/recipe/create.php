<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить рецепт</title>
    <script>
        /**
         * Функция для добавления нового шага в форму.
         * Создает новый элемент ввода для шага приготовления рецепта.
         */
        function addStep() {
            const stepsContainer = document.getElementById('steps-container'); // Контейнер для шагов
            const stepCount = stepsContainer.children.length + 1; // Получаем количество шагов, чтобы назначить новый номер

            const newStep = document.createElement('div'); // Создаем новый блок для шага
            newStep.innerHTML = ` 
                <label>Шаг ${stepCount}:</label><br>
                <input type="text" name="steps[]" required><br><br>
            `; // Вставляем HTML для нового шага

            stepsContainer.appendChild(newStep); // Добавляем новый шаг в контейнер
        }
    </script>
</head>
<body>
    <h1>Добавить рецепт</h1>
    <form action="/src/handlers/save_recipe.php" method="POST">
        <!-- Название рецепта -->
        <label for="title">Название рецепта:</label><br>
        <input type="text" id="title" name="title" required>
        <?php if (isset($errors['title'])): ?>
            <p style="color: red;"><?= $errors['title'] ?></p> <!-- Отображение ошибки, если есть -->
        <?php endif; ?><br><br>

        <!-- Категория рецепта -->
        <label for="category">Категория:</label><br>
        <select id="category" name="category" required>
            <option value="Завтрак">Завтрак</option>
            <option value="Обед">Обед</option>
            <option value="Ужин">Ужин</option>
            <option value="Десерт">Десерт</option>
        </select>
        <?php if (isset($errors['category'])): ?>
            <p style="color: red;"><?= $errors['category'] ?></p> <!-- Отображение ошибки, если есть -->
        <?php endif; ?><br><br>

        <!-- Ингредиенты -->
        <label for="ingredients">Ингредиенты:</label><br>
        <textarea id="ingredients" name="ingredients" rows="4" required></textarea>
        <?php if (isset($errors['ingredients'])): ?>
            <p style="color: red;"><?= $errors['ingredients'] ?></p> <!-- Отображение ошибки, если есть -->
        <?php endif; ?><br><br>

        <!-- Описание рецепта -->
        <label for="description">Описание рецепта:</label><br>
        <textarea id="description" name="description" rows="6" required></textarea>
        <?php if (isset($errors['description'])): ?>
            <p style="color: red;"><?= $errors['description'] ?></p> <!-- Отображение ошибки, если есть -->
        <?php endif; ?><br><br>

        <!-- Шаги приготовления -->
        <label>Шаги приготовления:</label><br>
        <div id="steps-container">
            <div>
                <label>Шаг 1:</label><br>
                <input type="text" name="steps[]" required><br><br> <!-- Поле для первого шага -->
            </div>
        </div>
        <!-- Кнопка для добавления нового шага -->
        <button type="button" onclick="addStep()">Добавить шаг</button> 
        <?php if (isset($errors['steps'])): ?>
            <p style="color: red;"><?= $errors['steps'] ?></p> <!-- Отображение ошибки, если есть -->
        <?php endif; ?><br><br>

        <!-- Тэги для рецепта -->
        <label for="tags">Тэги:</label><br>
        <select id="tags" name="tags[]" multiple size="4">
            <option value="Быстро">Быстро</option>
            <option value="Полезно">Полезно</option>
            <option value="Пикантно">Пикантно</option>
            <option value="Вегетарианское">Вегетарианское</option>
        </select><br><br>

        <!-- Кнопка отправки формы -->
        <button type="submit">Отправить</button> 
    </form>
</body>
</html>
