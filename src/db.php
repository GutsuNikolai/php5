<?php

// Подключаем конфигурацию с параметрами подключения
require_once __DIR__ . '/../config/db.php';

/**
 * Функция для подключения к базе данных
 *
 * @return PDO Экземпляр PDO, настроенный для работы с БД
 */
function getDbConnection(): PDO
{
    try {
        // Строка подключения для PostgreSQL
        $dsn = "pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";";
        
        // Создаем и возвращаем экземпляр PDO
        $pdo = new PDO($dsn, DB_USER, DB_PASS);

        // Настроим выбрасывание исключений при ошибках
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    } catch (PDOException $e) {
        // Если не удается подключиться, выбрасываем исключение с сообщением об ошибке
        echo "Ошибка подключения к базе данных: " . $e->getMessage();
        exit;
    }
}
