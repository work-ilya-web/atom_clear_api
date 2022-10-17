<?php

// override core en language system validation or define your own en language validation message
return [
    'max_length'            => 'Максимальная длинна поля {field} - {param} символов',
	'min_length'            => 'Минимальная длинна поля {field} - {param} символов',
    'is_unique'             => 'Пользователь таким {field}, уже есть на сайте ',
    'required'              => 'Поле требуется заполнить',
    'in_list'               => 'Поле может принимать только след. значения: {param}.',
    'in_db'                 => 'Нет записи с таким значением {field} в таблице {table}.',
    'valid_date'            => 'Дата не соответствует требуемому формату.',
    'numeric'               => 'Поле может быть только числовым.',
    'valid_email'           => 'Требуется указать корректный email',
];
