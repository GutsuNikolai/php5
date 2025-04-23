<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/db.php';

try {
    $pdo = getDbConnection();
    echo "✅ Успешное подключение к БД!";
} catch (PDOException $e) {
    echo "❌ Ошибка подключения: " . $e->getMessage();
}
