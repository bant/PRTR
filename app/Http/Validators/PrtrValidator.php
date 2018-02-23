<?php
namespace App\Http\Validators;

use Illuminate\Validation\Validator;

class PrtrValidator extends Validator
{
    public function validateNumeric2($attribute, $value, $parameters)
    {
        if ($value=='')
        {
            return true;
        }

        return is_numeric($value);
    }
}