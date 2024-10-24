<?php

require_once __DIR__ . '/ProductValidatorInterface.php';

class FurnitureValidator implements ProductValidatorInterface
{
    public function validate($data, array &$errors)
    {
        foreach (['height', 'width', 'length'] as $dimension) {
            if (empty($data->$dimension) || $data->$dimension <= 0) {
                $errors[] = "Please, provide the data of indicated type";
            }
        }
    }
}