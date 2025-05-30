<?php

$stdin = fopen(filename: "php://stdin", mode: "r");

echo "Введите имя: ";
$name = trim(string: fgets(stream: $stdin));

echo "Введите фамилию: ";
$surname = trim(string: fgets(stream: $stdin));

echo "Введите отчество: ";
$patronymic = trim(string: fgets(stream: $stdin));

fclose(stream: $stdin);

$fullname = mb_ucfirst(string: $surname) . ' ' . mb_ucfirst(string: $name) . ' ' . mb_ucfirst(string: $patronymic);

$surnameAndInitials = mb_ucfirst(string: $surname) . ' '
                    . mb_substr(string: mb_ucfirst(string: $name), start: 0, length: 1) . '.'
                    . mb_substr(string: mb_ucfirst(string: $patronymic), start: 0, length: 1) . '.';

$fio = mb_substr(string: mb_ucfirst(string: $surname), start: 0, length: 1)
     . mb_substr(string: mb_ucfirst(string: $name), start: 0, length: 1)
     . mb_substr(string: mb_ucfirst(string: $patronymic), start: 0, length: 1);

echo "\n";
echo "Полное имя: $fullname\n";
echo "Фамилия и инициалы: $surnameAndInitials\n";
echo "Аббревиатура: $fio\n";