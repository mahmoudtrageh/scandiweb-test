<?php

require_once __DIR__ . '/ProductValidatorInterface.php';

class DVDValidator implements ProductValidatorInterface
{
    public function validate($data, array &$errors)
    {
        if (empty($data->size) || $data->size <= 0) {
            $errors[] = 'Please, provide the data of indicated type';
        }
    }
}