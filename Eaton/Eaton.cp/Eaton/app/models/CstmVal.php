<?php
namespace App\Models;

class CstmVal extends \Illuminate\Validation\Validator

    public function cstmval ($attribute, $value, $parameters)
    {
        $strip = trim(mb_convert_kana($value, "s", 'UTF-8'));

        if (empty($strip)) {
            return false;
        }
        return true;
    }
}
