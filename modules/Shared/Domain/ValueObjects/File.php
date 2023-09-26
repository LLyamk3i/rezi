<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\ValueObjects;

final class File
{
    public function __construct(
        public readonly string $name,
        public readonly string $mime,
        public readonly string $path,
        public readonly string $disk,
        public readonly string $hash,
        public readonly int $size,
        public readonly string $original,
        public readonly string $collection,
    ) {
    }

    /**
     * @return array{name:string,mime:string,path:string,disk:string,hash:string,size:int,original:string,collection:string}
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'mime' => $this->mime,
            'path' => $this->path,
            'disk' => $this->disk,
            'hash' => $this->hash,
            'size' => $this->size,
            'original' => $this->original,
            'collection' => $this->collection,
        ];
    }
}
