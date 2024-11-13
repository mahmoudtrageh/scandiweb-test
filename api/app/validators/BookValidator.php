<?php

require_once __DIR__ . '/Validator.php';

class BookValidator implements Validator
{
    public function validate($data, array &$errors)
    {
        if (!isset($data->weight) || (is_null($data->weight) || trim($data->weight) === '')) {
            $errors[] = "Please, submit required data";
        }

        if (empty($data->weight) || $data->weight <= 0) {
            $errors[] = 'Please, provide the data of indicated type';
        }
    }
}