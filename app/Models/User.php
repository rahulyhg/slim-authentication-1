<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'users';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * @var array $guarded
     */
    protected $guarded = [
        'id',
    ];

    /**
     * @param string $email
     * @return null|User
     */
    public static function getByEmail(string $email): ?self
    {
        return self::where('email', $email)->first();
    }

    /**
     * @param string $password
     * @return bool
     */
    public function setPassword(string $password): bool
    {
       return $this->update([
           'password' => password_hash($password, PASSWORD_BCRYPT, [
               'cost' => 12,
           ])
       ]);
    }
}