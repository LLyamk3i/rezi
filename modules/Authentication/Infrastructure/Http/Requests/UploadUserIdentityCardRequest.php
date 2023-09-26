<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Http\Requests;

use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Authentication\Infrastructure\Models\User;
use Modules\Authentication\Domain\Factories\UserFactory;

use Modules\Shared\Infrastructure\Factories\FileFactory;

use Modules\Authentication\Infrastructure\Services\UploadIdentityCardService;
use Modules\Authentication\Domain\UseCases\UploadIdentityCard\UploadIdentityCardRequest as Request;

use function Modules\Shared\Infrastructure\Helpers\string_value;

/**
 * @phpstan-import-type UserRecord from \Modules\Authentication\Domain\Factories\UserFactory
 */
final class UploadUserIdentityCardRequest extends FormRequest
{
    /**
     * @return array{'card.recto':string,'card.verso':string}
     */
    public function rules(): array
    {
        return [
            'card.recto' => 'required|image|max:5120',
            'card.verso' => 'required|image|max:5120',
        ];
    }

    public function approved(): Request
    {
        $user = $this->user();
        $recto = $this->file(key: 'card.recto');
        $verso = $this->file(key: 'card.verso');

        if (! ($user instanceof User)) {
            throw new \RuntimeException(message: 'Account not found', code: 1);
        }
        /** @phpstan-var UserRecord $data */
        $data = $user->toArray();

        if (! ($recto instanceof UploadedFile)) {
            throw new \RuntimeException(message: 'Identity card not uploaded', code: 1);
        }
        if (! ($verso instanceof UploadedFile)) {
            throw new \RuntimeException(message: 'Identity card not uploaded', code: 1);
        }

        return new Request(
            account: (new UserFactory())->make(data: $data),
            upload: new UploadIdentityCardService(
                recto: $recto,
                verso: $verso,
                factory: new FileFactory(),
                disk: string_value(value: config(key: 'app.upload.disk')),
            ),
            map: string_value(value: with(
                value: $user,
                callback: static fn (User $user): string => $user->getMorphClass()
            )),
        );
    }
}
