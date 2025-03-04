<?php

declare(strict_types=1);

namespace Modules\Shared\Application\Commands;

use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Shared\Domain\Contracts\GeneratorContract;
use Modules\Shared\Domain\Commands\GenerateUlidContract;

final readonly class GenerateUlid implements GenerateUlidContract
{
    public function __construct(
        private GeneratorContract $generator,
    ) {
        //
    }

    /**
     * @throws \Modules\Shared\Domain\Exceptions\InvalidValueObjectException
     */
    public function handle(): Ulid
    {
        return new Ulid(value: $this->generator->generate());
    }
}
