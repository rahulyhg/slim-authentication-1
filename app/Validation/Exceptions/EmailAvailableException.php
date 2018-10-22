<?php

namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class EmailAvailableException extends ValidationException
{
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => '{{name}} already exists. Pick another one.',
        ],
        //self::MODE_NEGATIVE => [
            //self::STANDARD => 'This is a negative behavior',
        //],
    ];
}