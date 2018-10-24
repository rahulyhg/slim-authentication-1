<?php

namespace App\Validation\Rules;

use App\Models\User;
use Respect\Validation\Rules\AbstractRule;

class MatchesPassword extends AbstractRule
{
    /**
     * @var string $password
     */
    protected $password;

    /**
     * MatchesPassword constructor.
     *
     * @param string $password
     */
    public function __construct(string $password)
    {
        $this->password = $password;
    }

    /**
     * Checking for validness of the user's old password
     *
     * @param string $input
     * @return bool
     */
    public function validate($input): bool
    {
        return password_verify($input, $this->password);
    }
}