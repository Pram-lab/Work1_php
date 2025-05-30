<?php
echo 'Название файла: ' . basename(__FILE__)."\n";
echo 'Строка: ' . __LINE__ . "\n";

$name = "Ефпатий";
$message = <<<MSG
Здравствуйте, $name!
Добро пожаловать на обучение.
Желаем удачи в освоении материала!
MSG;
echo $message . "\n";

$a='Кошка';
$b='медведь';

echo $a . " рыбою сыта, а ". $b . " ягодами" . "\n";

$variable = 3.14;

if (is_bool($variable)) {
    echo "bool" . PHP_EOL;
} elseif (is_float($variable)) {
    echo "float" . PHP_EOL;
} elseif (is_int($variable)) {
    echo "int" . PHP_EOL;
} elseif (is_string($variable)) {
    echo "string" . PHP_EOL;
} elseif (is_null($variable)) {
    echo "null" . PHP_EOL;
} elseif (is_array($variable) || is_object($variable) || is_resource($variable)) {
    echo "other" . PHP_EOL;
} else {
    echo "unknown" . PHP_EOL;
} 

$variable = 2; 

switch (true) {
    case is_bool($variable):
        echo "bool";
        break;
    case is_float($variable):
        echo "float";
        break;
    case is_int($variable):
        echo "int";
        break;
    case is_string($variable):
        echo "string";
        break;
    case is_null($variable):
        echo "null";
        break;
    case is_array($variable):
    case is_object($variable):
    case is_resource($variable):
        echo "other";
        break;
    default:
        echo "unknown";
        break;
    }
?>