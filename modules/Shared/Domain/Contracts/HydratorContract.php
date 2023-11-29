<?php

declare(strict_types=1);

namespace Modules\Shared\Domain\Contracts;

/**
 * @template T1
 * @template T2
 */
interface HydratorContract
{
    /**
     * @param array<int,T1> $data
     *
     * @return array<int,T2>
     */
    public function hydrate(array $data): array;
}
