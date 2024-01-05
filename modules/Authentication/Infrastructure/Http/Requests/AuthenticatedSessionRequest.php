<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class AuthenticatedSessionRequest extends FormRequest
{
    /**
     * @return array{email:string,password:string,phone:string,device:string}
     */
    public function rules(): array
    {
        return [
            'device' => 'required|string',
            'password' => 'required|string',
            'email' => 'required_if:phone,null|email',
            'phone' => 'required_if:email,null|string',
        ];
    }

    /**
     * @return array<string,mixed>
     */
    public function access(): array
    {
        return $this->safe(keys: ['email', 'phone']);
    }
}
