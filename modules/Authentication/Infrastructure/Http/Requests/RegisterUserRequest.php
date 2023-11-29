<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Http\Requests;

use Illuminate\Validation\Rules\Password;

use Illuminate\Foundation\Http\FormRequest;

use Modules\Authentication\Domain\UseCases\RegisterUser\RegisterUserRequest as Request;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final class RegisterUserRequest extends FormRequest
{
    /**
     * @return array{forename:string,surname:string,email:string,password:array<int,string|Password|null>}
     */
    public function rules(): array
    {
        return [
            'forename' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function approved(): Request
    {
        return new Request(
            forename: string_value(value: $this->input(key: 'forename')),
            surname: string_value(value: $this->input(key: 'surname')),
            email: string_value(value: $this->input(key: 'email')),
            password: string_value(value: $this->input(key: 'password')),
        );
    }
}
