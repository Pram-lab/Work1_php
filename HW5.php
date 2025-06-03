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
    echo "Месяц: $monthName $year" . PHP_EOL;

    $weekDaysHeader = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
    echo implode(' ', array_map(fn($d) => str_pad($d, 4), $weekDaysHeader)) . PHP_EOL;

    $currentDay = 1;

    $firstDate = new DateTime("$year-$month-01");
    $firstWeekDay = (int)$firstDate->format('N');

    for ($i = 1; $i < $firstWeekDay; $i++) {
        printf("%-4s", '');
    }

    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    while ($currentDay <= $daysInMonth) {
        if ($dayCounter % 3 === 1) {
            $date = new DateTime("$year-$month-$currentDay");
            $weekDay = (int)$date->format('N');

            if ($weekDay >= 6) {
                $nextMonday = clone $date;
                $nextMonday->modify('next monday');
                $nextMondayDay = (int)$nextMonday->format('j');
                $nextMondayMonth = (int)$nextMonday->format('n');

                if ($nextMondayMonth == $month) {
                    printf("%-4s", '');
                } else {
                    break;
                }
            } else {
                $coloredDay = "\033[31m" . str_pad($currentDay, 4) . "\033[0m";
                printf("%-4s", $coloredDay);
            }
        } else {
            $coloredDay = "\033[32m" . str_pad($currentDay, 4) . "\033[0m";
            printf("%-4s", $coloredDay);
        }

        if ((($firstWeekDay + $currentDay - 1) % 7) == 0) {
            echo PHP_EOL;
        }

        $currentDay++;
        $dayCounter++;
    }

    echo PHP_EOL . PHP_EOL;
}

if ($argc < 4) {
    echo "Использование: php HW5.php <год> <месяц> <количество_месяцев>" . PHP_EOL;
    exit(1);
}

$startYear = (int)$argv[1];
$startMonth = (int)$argv[2];
$totalMonths = (int)$argv[3];

if ($startMonth < 1 || $startMonth > 12 || $startYear < 1900 || $startYear > 2100 || $totalMonths < 1) {
    echo "Ошибка: неверные значения года или количества месяцев." . PHP_EOL;
    exit(1);
}

$dayCounter = 1; 

for ($i = 0; $i < $totalMonths; $i++) {
    $currentYear = (int)date('Y', mktime(0, 0, 0, $startMonth + $i, 1, $startYear));
    $currentMonth = (int)date('n', mktime(0, 0, 0, $startMonth + $i, 1, $startYear));

    printWorkSchedule($currentYear, $currentMonth, $dayCounter);
}

echo "Рабочие дни выделены красным цветом. Нерабочие дни — зелёным." . PHP_EOL;