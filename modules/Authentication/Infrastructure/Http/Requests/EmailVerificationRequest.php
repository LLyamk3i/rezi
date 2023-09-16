<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Authentication\Domain\ValueObjects\Otp;
use Modules\Authentication\Infrastructure\Rules\Otp as RulesOtp;
use Modules\Authentication\Domain\UseCases\VerifyUserAccount\VerifyUserAccountRequest;

final class EmailVerificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array{id:string,code:array{'required',RulesOtp}}
     */
    public function rules(): array
    {
        return [
            'id' => 'required|string',
            'code' => ['required', new RulesOtp],
        ];
    }

    public function approved(): VerifyUserAccountRequest
    {
        return new VerifyUserAccountRequest(
            id: new Ulid(value: (string) $this->string(key: 'id')),
            code: new Otp(value: (string) $this->string(key: 'code')),
        );
    }
}
