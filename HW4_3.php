<?php

const OPERATION_EXIT = 0;
const OPERATION_ADD = 1;
const OPERATION_DELETE = 2;
const OPERATION_PRINT = 3;
const OPERATION_EDIT = 4; // новая операция

$operations = [
    OPERATION_EXIT => '0. Завершить программу.',
    OPERATION_ADD => '1. Добавить товар в список покупок.',
    OPERATION_DELETE => '2. Удалить товар из списка покупок.',
    OPERATION_PRINT => '3. Отобразить список покупок.',
    OPERATION_EDIT => '4. Редактировать товар.',
];

$items = [];

function getOperationFromUser(array $items): int
{
    system('clear'); // Для Windows: system('cls');

    if (!empty($items)) {
        echo 'Ваш список покупок:' . PHP_EOL;
        foreach ($items as $item) {
            echo "- {$item['name']} ({$item['quantity']})" . PHP_EOL;
        }
        echo PHP_EOL;
    } else {
        echo 'Ваш список покупок пуст.' . PHP_EOL . PHP_EOL;
    }

    echo 'Выберите операцию для выполнения:' . PHP_EOL;
    echo implode(PHP_EOL, $GLOBALS['operations']) . PHP_EOL . '> ';

    do {
        $operationNumber = trim(fgets(STDIN));

        if (array_key_exists($operationNumber, $GLOBALS['operations'])) {
            return (int)$operationNumber;
        }

        system('clear');
        echo '!!! Неизвестный номер операции, повторите попытку.' . PHP_EOL;
        echo 'Выберите операцию для выполнения:' . PHP_EOL;
        echo implode(PHP_EOL, $GLOBALS['operations']) . PHP_EOL . '> ';
    } while (true);
}

function addItem(array &$items): void
{
    echo "Введите название товара:" . PHP_EOL . '> ';
    $itemName = trim(fgets(STDIN));

    echo "Введите количество товара '{$itemName}':" . PHP_EOL . '> ';
    $itemQuantity = trim(fgets(STDIN));
    $itemQuantity = is_numeric($itemQuantity) ? (int)$itemQuantity : 1;

    $items[] = [
        'name' => $itemName,
        'quantity' => $itemQuantity
    ];

    echo "Товар '{$itemName}' в количестве {$itemQuantity} шт добавлен." . PHP_EOL;
    echo 'Нажмите Enter для продолжения';
    fgets(STDIN);
}

function deleteItem(array &$items): void
{
    if (empty($items)) {
        echo 'Список покупок пуст, нечего удалять.' . PHP_EOL;
        echo 'Нажмите Enter для продолжения';
        fgets(STDIN);
        return;
    }

    echo 'Текущий список покупок:' . PHP_EOL;
    foreach ($items as $index => $item) {
        echo "{$index}. {$item['name']} ({$item['quantity']})" . PHP_EOL;
    }

    echo 'Введите номер товара для удаления:' . PHP_EOL . '> ';
    $itemIndex = trim(fgets(STDIN));

    if (isset($items[$itemIndex])) {
        $name = $items[$itemIndex]['name'];
        unset($items[$itemIndex]);
        $items = array_values($items); // Перенумеровываем индексы
        echo "Товар '{$name}' удален." . PHP_EOL;
    } else {
        echo "Неверный номер товара." . PHP_EOL;
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
        foreach ($items as $index => $item) {
            echo "{$index}. {$item['name']} ({$item['quantity']})" . PHP_EOL;
        }
    }

    echo 'Нажмите Enter для продолжения';
    fgets(STDIN);
}

function editItem(array &$items): void
{
    if (empty($items)) {
        echo 'Список покупок пуст, нечего редактировать.' . PHP_EOL;
        echo 'Нажмите Enter для продолжения';
        fgets(STDIN);
        return;
    }

    echo 'Текущий список покупок:' . PHP_EOL;
    foreach ($items as $index => $item) {
        echo "{$index}. {$item['name']} ({$item['quantity']})" . PHP_EOL;
    }

    echo 'Введите номер товара для редактирования:' . PHP_EOL . '> ';
    $itemIndex = trim(fgets(STDIN));

    if (!isset($items[$itemIndex])) {
        echo 'Неверный номер товара.' . PHP_EOL;
        echo 'Нажмите Enter для продолжения';
        fgets(STDIN);
        return;
    }

    $oldName = $items[$itemIndex]['name'];
    $oldQuantity = $items[$itemIndex]['quantity'];

    echo "Текущее название: {$oldName}. Введите новое название (оставьте пустым, чтобы не менять):" . PHP_EOL . '> ';
    $newName = trim(fgets(STDIN));
    if ($newName === '') {
        $newName = $oldName;
    }

    echo "Текущее количество: {$oldQuantity}. Введите новое количество (оставьте пустым, чтобы не менять):" . PHP_EOL . '> ';
    $newQuantity = trim(fgets(STDIN));
    if ($newQuantity === '') {
        $newQuantity = $oldQuantity;
    } else {
        $newQuantity = is_numeric($newQuantity) ? (int)$newQuantity : $oldQuantity;
    }

    $items[$itemIndex]['name'] = $newName;
    $items[$itemIndex]['quantity'] = $newQuantity;

    echo "Товар изменён: {$oldName} → {$newName}, количество: {$oldQuantity} → {$newQuantity}" . PHP_EOL;
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

        case OPERATION_EDIT:
            editItem($items);
            break;
    }

    echo "\n -----\n";
} while ($operationNumber > 0);

echo 'Программа завершена' . PHP_EOL;