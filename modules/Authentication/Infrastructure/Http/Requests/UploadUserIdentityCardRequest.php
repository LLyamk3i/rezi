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
            'document_type' => 'required|string',
            'card_recto' => 'image|max:5120|required',
            'card_verso' => 'image|max:5120|required_if:document_type,passeport',
        ];
    }

    /**
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function approved(): Request
    {
        $user = $this->user();
        $recto = $this->file(key: 'card_recto');
        $verso = $this->file(key: 'card_verso');

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
                document: (string) $this->string(key: 'document_type'),
                disk: string_value(value: config(key: 'app.upload.disk')),
            ),
            fileable: string_value(value: with(
                value: $user,
                callback: static fn (User $user): string => $user->getMorphClass()
            )),
        );
    }
}
