<?php

require_once __DIR__ . '/Validator.php';

class DVDValidator implements Validator
{
    public function validate($data, array &$errors)
    {
        if (empty($data->size) || $data->size <= 0) {
            $errors[] = 'Please, provide the data of indicated type';
        }
    }
}