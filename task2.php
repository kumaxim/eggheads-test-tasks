<?php

/* === Сделайте рефакторинг === */

/* === Исходная версия === */
$questionsQ = $mysqli->query('SELECT * FROM questions WHERE catalog_id=' . $catId);
$result     = array();
while ($question = $questionsQ->fetch_assoc()) {
    $userQ    = $mysqli->query('SELECT name, gender FROM users WHERE id=' . $question['user_id']);
    $user     = $userQ->fetch_assoc();
    $result[] = array('question' => $question, 'user' => $user);
    $userQ->free();
}
$questionsQ->free();

/* === Предлагаемая версия === */
$pdo = new \PDO(null, null, null);

$result = array();
$catId  = 0;

$questionsQ = $pdo->prepare("SELECT * FROM questions WHERE catalog_id = ?");
$questionsQ->execute([$catId]);
$question = $questionsQ->fetchAll(PDO::FETCH_ASSOC);

$users_id = [];
array_walk($question, function ($value) use ($users_id) {
    $users_id[] = $value['user_id'];
});

$sql_in = str_repeat('?,', count($users_id) - 1) . '?';
$userQ  = $pdo->prepare("SELECT name, gender FROM users WHERE id IN ({$sql_in})");
$userQ->execute($users_id);
$user = $userQ->fetchAll(PDO::FETCH_ASSOC);

foreach ($question as $n => $value) {
    $result[] = ['question' => $value, 'user' => $user[$n] ?? null];
}

$pdo = null;
