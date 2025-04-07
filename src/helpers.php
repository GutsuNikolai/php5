<?php
/**
 * Функция для фильтрации данных.
 * Она удаляет лишние пробелы и преобразует специальные символы в HTML-сущности для предотвращения XSS-атак.
 * 
 * @param string $data Данные, которые нужно фильтровать.
 * @return string Отфильтрованные данные.
 */
function filterData($data) {
    return htmlspecialchars(trim($data));
}
?>
