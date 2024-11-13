<?php

require_once __DIR__ . '/Validator.php';

class FurnitureValidator implements Validator
{
    public function validate($data, array &$errors)
    {
        $requiredFields = ['height', 'width', 'length'];

        foreach ($requiredFields as $dimension) {

            if (!isset($data->$dimension) || (is_null($data->$dimension) || trim($data->$dimension) === '')) {
                $errors[] = "Please, submit required data";
                break;
            }

            if (empty($data->$dimension) || $data->$dimension <= 0) {
                $errors[] = "Please, provide the data of indicated type";
            }
        }
    }
}