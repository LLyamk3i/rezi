<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class AuthenticatedSessionRequest extends FormRequest
{
    /**
     * @return array{email:string,password:string,device:string}
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
            'device' => 'required|string',
        ];
    }
}
