<?php

function printWorkSchedule(int $year, int $month, int &$dayCounter): void
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
    echo " Месяц: $monthName $year\n";

    $weekDaysHeader = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
    foreach ($weekDaysHeader as $dayName) {
        printf("%-6s", $dayName);
    }
    echo "\n";

    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    $firstDate = new DateTime("$year-$month-01");
    $firstWeekDay = (int)$firstDate->format('N');

    for ($i = 1; $i < $firstWeekDay; $i++) {
        printf("%-4s", '');
    }

    for ($day = 1; $day <= $daysInMonth; $day++) {
        $date = new DateTime("$year-$month-$day");
        $weekDay = (int)$date->format('N');

        if ($weekDay >= 6) {
            $coloredDay = "\033[32m" . str_pad($day, 4) . "\033[0m";
        } elseif ($dayCounter % 3 === 1) {
            $coloredDay = "\033[31m" . str_pad($day, 4) . "\033[0m";
        } else {
            $coloredDay = "\033[32m" . str_pad($day, 4) . "\033[0m";
        }

        printf("%-4s", $coloredDay);

        if ((($firstWeekDay + $day - 1) % 7) == 0 || $day == $daysInMonth) {
            echo "\n";
        }

        $dayCounter++;
    }

    echo "\n";
}


if ($argc < 4) {
    echo "Использование: php HW5.php <год> <месяц> <кол_мес>\n";
    exit(1);
}

$startYear = (int)$argv[1];
$startMonth = (int)$argv[2];
$totalMonths = (int)$argv[3];

if ($startMonth < 1 || $startMonth > 12 || $startYear < 1900 || $startYear > 2100 || $totalMonths < 1) {
    echo "Ошибка: неверные значения года или количества месяцев.\n";
    exit(1);
}

$dayCounter = 1;

for ($i = 0; $i < $totalMonths; $i++) {
    $currentYear = (int)date('Y', mktime(0, 0, 0, $startMonth + $i, 1, $startYear));
    $currentMonth = (int)date('n', mktime(0, 0, 0, $startMonth + $i, 1, $startYear));

    printWorkSchedule($currentYear, $currentMonth, $dayCounter);
}

echo "Рабочие дни выделены красным. Нерабочие дни — зелёным.\n";