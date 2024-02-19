<?php

declare(strict_types=1);

namespace Modules\Authentication\Domain\Entities;

use Modules\Shared\Domain\ValueObjects\Ulid;

/**
 * @phpstan-type UserFormat array{id:string,forename:string,surname:string,email:string,phone:string,verified?:bool}
 */
final readonly class User
{
    public function __construct(
        public Ulid $id,
        public string $forename,
        public string $surname,
        public string $email,
        public string $phone,
        public bool $verified = false,
        public null | string $password = null,
    ) {
        //
    }

    /**
     * @phpstan-return UserFormat
     */
    public function __serialize(): array
    {
        return $this->serialize();
    }

    /**
     * @phpstan-return UserFormat
     */
    public function serialize(bool $saveable = false): array
    {
        $data = [
            'id' => $this->id->value,
            'forename' => $this->forename,
            'surname' => $this->surname,
            'email' => $this->email,
            'phone' => $this->phone,
        ];
        if (! $saveable) {
            $data['verified'] = $this->verified;
        }

        return $data;
    }
}
