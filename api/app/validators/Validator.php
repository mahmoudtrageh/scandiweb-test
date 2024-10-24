<?php
interface Validator
{
    public function validate($data, array &$errors);
}