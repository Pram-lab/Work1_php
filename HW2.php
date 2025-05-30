<?php

$stdin = fopen(filename: "php://stdin", mode: "r");

echo "Введите первое число: ";
$a = trim(string: fgets(stream: $stdin));

echo "Введите второе число: ";
$b = trim(string: fgets(stream: $stdin));

if (!is_numeric(value: $a) || (int)$a != $a) {
    fwrite(stream: STDERR, data: "Введите, пожалуйста, число\n");
    exit(1);
}

if (!is_numeric(value: $b) || (int)$b != $b) {
    fwrite(stream: STDERR, data: "Введите, пожалуйста, число\n");
    exit(1);
}

$a = (int)$a;
$b = (int)$b;

if ($b === 0) {
    fwrite(stream: STDERR, data: "Делить на 0 нельзя\n");
    exit(1);
}

$result = $a / $b;

echo "Результат: $result\n";

fclose(stream: $stdin);