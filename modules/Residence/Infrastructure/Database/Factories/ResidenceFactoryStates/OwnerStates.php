<?php

declare(strict_types=1);

namespace Modules\Residence\Infrastructure\Database\Factories\ResidenceFactoryStates;

use Modules\Authentication\Infrastructure\Models\User;

trait OwnerStates
{
    public function owner(): self
    {
        return $this->owners(count: 1);
    }

    public function owners(int $count): self
    {
        $owners = User::factory()->avatar()->count(count: $count)->create();

        return $this->state(state: ['user_id' => static fn (): \Illuminate\Support\Collection | \Illuminate\Database\Eloquent\Model => $owners->random()]);
    }
}
