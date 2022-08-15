<?php

/**
 * Опишите, какие проблемы могут возникнуть при использовании данного кода
 */

// 1. Использование старого драйвера. Можно, но я предпочитаю PDO
// 2. Использование "магических" строк. Smells по Clean code дяди Боба
// 3. Тривиальный пароль
$mysqli = new mysqli("localhost", "my_user", "my_password", "world");
// 3. Отсутствует фильтрация входящих данных
$id = $_GET['id'];
// 4. Использование модификатора * вместо имен конкретных полей. Smell по дяде Бобу, по-моему
$res  = $mysqli->query('SELECT * FROM users WHERE u_id=' . $id);
$user = $res->fetch_assoc();

/* === Предлагаемая версия === */
const DB_HOST     = 'localhost';
const DB_PORT     = 3306;
const DB_CHARSET  = 'utf8mb4';
const DB_DATABASE = 'world';
const DB_USER     = 'my_user';
const DB_PASSWORD = 'my_password';


if (filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) {
    $dsn = sprintf(' mysql:host=%s;port=%s;dbname=%s;charset=%s', DB_HOST, DB_PORT, DB_DATABASE, DB_CHARSET);
    $pdo = new \PDO($dsn, DB_USER, DB_PASSWORD);

    $id    = (int)$_GET['id'];

    $query = $pdo->prepare("SELECT id, name FROM users WHERE u_id = ?");
    $query->execute($id);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    var_dump($result);
}
