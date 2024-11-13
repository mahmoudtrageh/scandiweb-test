<?php

require_once __DIR__ . '/Validator.php';

class DVDValidator implements Validator
{
    public function validate($data, array &$errors)
    {
        if (!isset($data->size) || (is_null($data->size) || trim($data->size) === '')) {
            $errors[] = "Please, submit required data";
        }

        if (empty($data->size) || $data->size <= 0) {
            $errors[] = 'Please, provide the data of indicated type';
        }
    }
}