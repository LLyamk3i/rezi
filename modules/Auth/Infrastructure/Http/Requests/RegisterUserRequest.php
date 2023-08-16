<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Http\Requests;

use Symfony\Component\Uid\Ulid;

use Illuminate\Validation\Rules\Password;

use Illuminate\Foundation\Http\FormRequest;

use function Modules\Shared\Infrastructure\Helpers\string_value;

use Modules\Shared\Domain\ValueObjects\Ulid as ValueObjectsUlid;
use Modules\Auth\Domain\UseCases\RegisterUser\RegisterUserRequest as Request;

final class RegisterUserRequest extends FormRequest
{
    /**
     * @return array{name:string,surname:string,email:string,password:array<int,string|Password|null>}
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function approved(): Request
    {
        return new Request(
            id: new ValueObjectsUlid(value: Ulid::generate()),
            name: string_value(value: $this->input(key: 'name')),
            surname: string_value(value: $this->input(key: 'surname')),
            email: string_value(value: $this->input(key: 'email')),
            password: string_value(value: $this->input(key: 'password')),
        );
    }
}
