<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class ProfileUpdateRequest extends FormRequest
{
    /**
     * @return array{emergency_contact: string, forename: string, surname: string, address: string}
     */
    public function rules(): array
    {
        return [
            'emergency_contact' => 'string',
            'forename' => 'string',
            'surname' => 'string',
            'address' => 'string',
        ];
    }
}
