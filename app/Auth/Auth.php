<?php

namespace App\Auth;

use App\Models\User;
use Psr\Container\ContainerInterface as Container;

class Auth
{
    /**
     * @var Container $container
     */
    protected $container;

    /**
     * Auth constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function attempt(string $email, string $password): bool
    {
        if (($user = User::getByEmail($email)) === null) {
            return false;
        }

        if (! password_verify($password, $user->password)) {
            return false;
        }

        $this->signin($user);

        return true;
    }

    /**
     * @return null|User
     */
    public function user(): ?User
    {
        return ($this->check()) ? User::find($_SESSION['user']['id']) : null;
    }

    /**
     * @return bool
     */
    public function check(): bool
    {
        return ! empty($_SESSION['user']);
    }

    /**
     * @param User $user
     */
    public function signin(User $user): void
    {
        $_SESSION['user'] = [
            'id'            => $user->id,
            'name'          => $user->name,
            'email'         => $user->email,
        ];
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        unset($_SESSION['user']);
        session_regenerate_id(true);
    }
}