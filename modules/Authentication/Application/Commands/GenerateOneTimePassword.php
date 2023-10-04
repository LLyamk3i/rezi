<?php

declare(strict_types=1);

namespace Modules\Authentication\Application\Commands;

use Modules\Shared\Domain\Contracts\GeneratorContract;
use Modules\Authentication\Domain\Commands\GenerateOneTimePasswordContract;

final readonly class GenerateOneTimePassword implements GenerateOneTimePasswordContract
{
    public function __construct(
        private GeneratorContract $generator,
    ) {
        //
    }

    public function handle(): string
    {
        $code = $this->generator->generate();

        return substr(string: $code, offset: 0, length: 3) . '-' . substr(string: $code, offset: 3);
    }
}
