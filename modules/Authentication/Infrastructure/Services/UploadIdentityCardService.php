<?php

declare(strict_types=1);

namespace Modules\Authentication\Infrastructure\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Residence\Domain\Enums\Media;
use Modules\Shared\Domain\ValueObjects\File;
use Modules\Shared\Infrastructure\Factories\FileFactory;
use Modules\Authentication\Domain\ValueObjects\Cards\Identity;
use Modules\Authentication\Domain\Services\UploadIdentityCardServiceContract;

use function Modules\Shared\Infrastructure\Helpers\string_value;
use function Modules\Shared\Infrastructure\Helpers\array_filter_filled;

final readonly class UploadIdentityCardService implements UploadIdentityCardServiceContract
{
    public function __construct(
        private string $disk,
        private string $document,
        private UploadedFile $recto,
        private FileFactory $factory,
        private UploadedFile | null $verso,
    ) {
    }

    public function run(): Identity
    {
        $files = array_map(array: array_filter_filled(array: $this->files()), callback: function (UploadedFile $file): File {
            $path = Storage::disk(name: $this->disk)->put(path: 'users/identity-cards', contents: $file);

            return $this->factory->make(
                file: $file,
                path: string_value(value: $path),
                disk: $this->disk,
                type: Media::Identity,
                collection: "identity-cards/{$this->document}",
            );
        });

        return new Identity(...$files);
    }

    /**
     * @return array{recto:UploadedFile,verso:UploadedFile|null}
     */
    private function files(): array
    {
        return [
            'recto' => $this->recto,
            'verso' => $this->verso,
        ];
    }
}
