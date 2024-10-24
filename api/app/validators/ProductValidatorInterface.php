<?php
interface ProductValidatorInterface
{
    public function validate($data, array &$errors);
}