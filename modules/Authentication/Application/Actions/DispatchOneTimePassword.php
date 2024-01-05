<?php

declare(strict_types=1);

namespace Modules\Authentication\Application\Actions;

use Modules\Authentication\Domain\Entities\User;
use Modules\Authentication\Domain\Actions\DispatchOneTimePasswordContract;
use Modules\Authentication\Domain\Commands\GenerateOneTimePasswordContract;
use Modules\Authentication\Domain\Commands\RememberOneTimePasswordRequestContract;
use Modules\Authentication\Domain\Commands\SendOneTimePasswordNotificationContract;

final readonly class DispatchOneTimePassword implements DispatchOneTimePasswordContract
{
    public function __construct(
        private GenerateOneTimePasswordContract $code,
        private RememberOneTimePasswordRequestContract $remember,
        private SendOneTimePasswordNotificationContract $notification,
    ) {
        //
    }

    public function execute(User $user): void
    {
        tap(value: $this->code->handle(), callback: function (string $code) use ($user): void {
            $this->notification->handle(code: $code, user: $user);
            $this->remember->handle(email: $user->email, code: $code);
        });
    }
}
