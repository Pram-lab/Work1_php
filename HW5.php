<?php

function printMonthWorkDays(int $year, int $month): void
{
    $months = [
        1 => 'Январь',
        2 => 'Февраль',
        3 => 'Март',
        4 => 'Апрель',
        5 => 'Май',
        6 => 'Июнь',
        7 => 'Июль',
        8 => 'Август',
        9 => 'Сентябрь',
        10 => 'Октябрь',
        11 => 'Ноябрь',
        12 => 'Декабрь'
    ];

    $monthName = $months[$month] ?? 'Неизвестный месяц';

    echo "Месяц: $monthName $year" . PHP_EOL;
    echo "Все дни месяца:" . PHP_EOL;

    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    for ($day = 1; $day <= $daysInMonth; $day++) {
        $date = new DateTime("$year-$month-$day");

        $weekDay = (int)$date->format('N');

        if ($weekDay <= 5) {
            echo "\033[32m$day\033[0m ";
        } else {
            echo "$day "; 
        }

        if ($weekDay === 7 || $day === $daysInMonth) {
            echo PHP_EOL;
        }
    }

    echo PHP_EOL . "Рабочие дни выделены зелёным цветом." . PHP_EOL . PHP_EOL;
}

if ($argc < 4) {
    echo "Использование: php work_days.php <год> <месяц> <количество_месяцев>" . PHP_EOL;
    exit(1);
}

$startYear = (int)$argv[1];
$startMonth = (int)$argv[2];
$totalMonths = (int)$argv[3];

if ($startMonth < 1 || $startMonth > 12 || $startYear < 1900 || $startYear > 2100 || $totalMonths < 1) {
    echo "Ошибка: неверные значения года или количества месяцев." . PHP_EOL;
    exit(1);
}

for ($i = 0; $i < $totalMonths; $i++) {
    $currentYear = (int)date('Y', mktime(0, 0, 0, $startMonth + $i, 1, $startYear));
    $currentMonth = ((int)date('n', mktime(0, 0, 0, $startMonth + $i, 1, $startYear)));

    printMonthWorkDays($currentYear, $currentMonth);
}