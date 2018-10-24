<?php

namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class MatchesPasswordException extends ValidationException
{
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Your old password is not valid ! Please, check again.',
        ],
        //self::MODE_NEGATIVE => [
        //self::STANDARD => 'This is a negative behavior',
        //],
    ];
}