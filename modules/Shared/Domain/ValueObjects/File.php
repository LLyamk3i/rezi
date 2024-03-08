<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\ValueObjects;

use Modules\Residence\Domain\Enums\Media;

final readonly class File
{
    use \Modules\Shared\Domain\Concerns\Serializable;

    public function __construct(
        public int $size,
        public Media $type,
        public string $name,
        public string $mime,
        public string $path,
        public string $disk,
        public string $hash,
        public string $original,
        public string $collection,
    ) {
    }

    /**
     * @return array{name:string,type:string,mime:string,path:string,disk:string,hash:string,size:int,original:string,collection:string}
     */
    public function serialize(): array
    {
        return [
            'name' => $this->name,
            'type' => $this->type->value,
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
