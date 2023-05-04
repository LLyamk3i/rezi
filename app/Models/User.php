<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

final class User extends Authenticatable
{
    use \Laravel\Sanctum\HasApiTokens;
    use \Illuminate\Notifications\Notifiable;
    use \Illuminate\Database\Eloquent\Concerns\HasUlids;

    /**
     * @var array<int,string>
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * @var array<int,string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function factory(): UserFactory
    {
        return new UserFactory();
    }
}
