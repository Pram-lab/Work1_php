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

    $actualWorkingDays = [];

    $currentDay = 1;
    $currentDate = clone $firstDate;

    while ($currentDay <= $daysInMonth) {
        $weekDay = (int)$currentDate->format('N');

        if ($weekDay >= 6) {
            $currentDate->modify('+1 day');
            $currentDay++;
            continue;
        }

        if (empty($actualWorkingDays)) {
            $actualWorkingDays[] = $currentDay;
            $dayCounter++;
            $currentDate->modify('+3 days');
            $currentDay += 3;
            continue;
        }

        $lastWorkDay = end($actualWorkingDays);
        $diffDays = $currentDay - $lastWorkDay;

        if ($diffDays >= 3) {
            if ($diffDays == 3) {
                $actualWorkingDays[] = $currentDay;
                $dayCounter++;
                $currentDate->modify('+3 days');
                $currentDay += 3;
            } else {
                $actualWorkingDays[] = $currentDay;
                $dayCounter++;
                $currentDate->modify('+3 days');
                $currentDay += 3;
            }
        } else {
            $currentDate->modify('+1 day');
            $currentDay++;
        }
    }

    $currentDay = 1;
    $currentDate = clone $firstDate;

    while ($currentDay <= $daysInMonth) {
        $weekDay = (int)$currentDate->format('N');

        if (in_array($currentDay, $actualWorkingDays)) {
            $coloredDay = "\033[31m" . str_pad($currentDay, 4) . "\033[0m";
        } elseif ($weekDay >= 6) {
            $coloredDay = "\033[32m" . str_pad($currentDay, 4) . "\033[0m";
        } else {
            $coloredDay = "\033[32m" . str_pad($currentDay, 4) . "\033[0m";
        }

        printf("%-4s", $coloredDay);

        if ((($firstWeekDay + $currentDay - 1) % 7) == 0 || $currentDay == $daysInMonth) {
            echo "\n";
        }

        $currentDate->modify('+1 day');
        $currentDay++;
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