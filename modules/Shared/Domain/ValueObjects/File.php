<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\ValueObjects;

final readonly class File
{
    public function __construct(
        public string $name,
        public string $mime,
        public string $path,
        public string $disk,
        public string $hash,
        public int $size,
        public string $original,
        public string $collection,
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
