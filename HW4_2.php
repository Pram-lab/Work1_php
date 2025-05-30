<?php

const OPERATION_EXIT = 0;
const OPERATION_ADD = 1;
const OPERATION_DELETE = 2;
const OPERATION_PRINT = 3;

$operations = [
    OPERATION_EXIT => '0. Завершить программу.',
    OPERATION_ADD => '1. Добавить товар в список покупок.',
    OPERATION_DELETE => '2. Удалить товар из списка покупок.',
    OPERATION_PRINT => '3. Отобразить список покупок.',
];

$items = [];

function getOperationFromUser(array $items): int
{
    system('cls'); // Для Windows: system('cls');

    if (!empty($items)) {
        echo 'Ваш список покупок:' . PHP_EOL;
        echo implode(PHP_EOL, $items) . PHP_EOL;
    } else {
        echo 'Ваш список покупок пуст.' . PHP_EOL;
    }

    echo 'Выберите операцию для выполнения:' . PHP_EOL;
    echo implode(PHP_EOL, $GLOBALS['operations']) . PHP_EOL . '> ';

    do {
        $operationNumber = trim(fgets(STDIN));

        if (array_key_exists($operationNumber, $GLOBALS['operations'])) {
            return (int)$operationNumber;
        }

        system('cls');
        echo '!!! Неизвестный номер операции, повторите попытку.' . PHP_EOL;
        echo 'Выберите операцию для выполнения:' . PHP_EOL;
        echo implode(PHP_EOL, $GLOBALS['operations']) . PHP_EOL . '> ';
    } while (true);
}

function addItem(array &$items): void
{
    echo "Введите название товара для добавления в список:" . PHP_EOL . '> ';
    $itemName = trim(fgets(STDIN));
    $items[] = $itemName;
}

function deleteItem(array &$items): void
{
    if (empty($items)) {
        echo 'Список покупок пуст, нечего удалять.' . PHP_EOL;
        echo 'Нажмите Enter для продолжения';
        fgets(STDIN);
        return;
    }

    echo 'Введите название товара для удаления:' . PHP_EOL . '> ';
    $itemName = trim(fgets(STDIN));

    if (($key = array_search($itemName, $items, true)) !== false) {
        unset($items[$key]);
        echo "Товар '$itemName' удален." . PHP_EOL;
    } else {
        echo "Товар '$itemName' не найден." . PHP_EOL;
    }

    echo 'Нажмите Enter для продолжения';
    fgets(STDIN);
}

function printItems(array $items): void
{
    if (empty($items)) {
        echo 'Список покупок пуст.' . PHP_EOL;
    } else {
        echo 'Ваш список покупок:' . PHP_EOL;
        echo implode(PHP_EOL, $items) . PHP_EOL;
        echo 'Всего ' . count($items) . ' позиций.' . PHP_EOL;
    }

    echo 'Нажмите Enter для продолжения';
    fgets(STDIN);
}

do {
    $operationNumber = getOperationFromUser($items);

    echo 'Выбрана операция: ' . $operations[$operationNumber] . PHP_EOL;

    switch ($operationNumber) {
        case OPERATION_ADD:
            addItem($items);
            break;

        case OPERATION_DELETE:
            deleteItem($items);
            break;

        case OPERATION_PRINT:
            printItems($items);
            break;
    }

    echo "\n -----\n";
} while ($operationNumber > 0);

echo 'Программа завершена' . PHP_EOL;