<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Shared\Infrastructure\Factories\FileFactory;
use Modules\Authentication\Domain\ValueObjects\Cards\Identity;

use Modules\Authentication\Domain\Services\UploadIdentityCardServiceContract;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final class UploadIdentityCardService implements UploadIdentityCardServiceContract
{
    public function __construct(
        private readonly UploadedFile $recto,
        private readonly UploadedFile $verso,
        private readonly FileFactory $factory,
        private readonly string $disk,
    ) {
    }

    public function run(): Identity
    {
        $files = array_map(array: $this->files(), callback: function (UploadedFile $file) {
            $path = Storage::disk(name: $this->disk)->put(path: 'users/identity-cards', contents: $file);

            return $this->factory->make(
                file: $file,
                path: string_value(value: $path),
                disk: $this->disk,
                collection: 'identity-cards',
            );
        });

        return new Identity(...$files);
    }

    /**
     * @return array{recto:UploadedFile,verso:UploadedFile}
     */
    private function files(): array
    {
        return [
            'recto' => $this->recto,
            'verso' => $this->verso,
        ];
    }
}
