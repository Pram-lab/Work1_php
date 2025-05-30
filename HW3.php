<?php

$name = 'павел';
$surname = 'овечкин';
$patronymic = 'платонович';

$fullName = mb_convert_case(string: $surname, mode: MB_CASE_TITLE, encoding: 'UTF-8') . ' '
          . mb_convert_case(string: $name, mode: MB_CASE_TITLE, encoding: 'UTF-8') . ' '
          . mb_convert_case(string: $patronymic, mode: MB_CASE_TITLE, encoding: 'UTF-8');

$surnameAndInitials = mb_convert_case(string: $surname, mode: MB_CASE_TITLE, encoding: 'UTF-8') . ' '
                    . mb_substr(string: mb_convert_case(string: $name, mode: MB_CASE_TITLE, encoding: 'UTF-8'), start: 0, length: 1) . '.'
                    . mb_substr(string: mb_convert_case(string: $patronymic, mode: MB_CASE_TITLE, encoding: 'UTF-8'), start: 0, length: 1) . '.';

$fio = mb_substr(string: mb_convert_case(string: $surname, mode: MB_CASE_TITLE, encoding: 'UTF-8'), start: 0, length: 1)
     . mb_substr(string: mb_convert_case(string: $name, mode: MB_CASE_TITLE, encoding: 'UTF-8'), start: 0, length: 1)
     . mb_substr(string: mb_convert_case(string: $patronymic, mode: MB_CASE_TITLE, encoding: 'UTF-8'), start: 0, length: 1);

echo "Полное имя: '$fullName'\n";
echo "Фамилия и инициалы: '$surnameAndInitials'\n";
echo "Аббревиатура: '$fio'\n";