<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Shared\Infrastructure\Factories\FileFactory;
use Modules\Authentication\Domain\ValueObjects\Cards\Identity;

use Modules\Authentication\Domain\Services\UploadIdentityCardServiceContract;

use function Modules\Shared\Infrastructure\Helpers\string_value;

final readonly class UploadIdentityCardService implements UploadIdentityCardServiceContract
{
    public function __construct(
        private UploadedFile $recto,
        private UploadedFile $verso,
        private FileFactory $factory,
        private string $disk,
    ) {
    }

    public function run(): Identity
    {
        $files = array_map(array: $this->files(), callback: function (UploadedFile $file): \Modules\Shared\Domain\ValueObjects\File {
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
