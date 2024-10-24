<?php

require_once __DIR__ . '/ProductValidatorInterface.php';

class BookValidator implements ProductValidatorInterface
{
    public function validate($data, array &$errors)
    {
        if (empty($data->weight) || $data->weight <= 0) {
            $errors[] = 'Please, provide the data of indicated type';
        }
    }
}