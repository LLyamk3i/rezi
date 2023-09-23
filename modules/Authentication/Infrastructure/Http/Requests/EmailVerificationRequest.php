<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Authentication\Domain\ValueObjects\Otp;
use Modules\Authentication\Domain\ValueObjects\Email;
use Modules\Authentication\Infrastructure\Rules\Otp as RulesOtp;
use Modules\Authentication\Domain\UseCases\VerifyUserAccount\VerifyUserAccountRequest;

final class EmailVerificationRequest extends FormRequest
{
    /**
     * @return array{email:string,code:array{'required',RulesOtp}}
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email:strict',
            'code' => ['required', new RulesOtp],
        ];
    }

    public function approved(): VerifyUserAccountRequest
    {
        return new VerifyUserAccountRequest(
            email: new Email(value: (string) $this->string(key: 'email')),
            code: new Otp(value: (string) $this->string(key: 'code')),
        );
    }
}
