<?php

declare(strict_types=1);

namespace Modules\Authentication\Application\Actions;

use Modules\Authentication\Domain\Actions\DispatchOneTimePasswordContract;
use Modules\Authentication\Domain\Commands\GenerateOneTimePasswordContract;
use Modules\Authentication\Domain\Commands\RememberOneTimePasswordRequestContract;
use Modules\Authentication\Domain\Commands\SendOneTimePasswordNotificationContract;

final readonly class DispatchOneTimePassword implements DispatchOneTimePasswordContract
{
    public function __construct(
        private GenerateOneTimePasswordContract $code,
        private SendOneTimePasswordNotificationContract $notification,
        private RememberOneTimePasswordRequestContract $remember,
    ) {
        //
    }

    public function execute(string $email): void
    {
        tap(value: $this->code->handle(), callback: function (string $code) use ($email): void {
            $this->notification->handle(code: $code, email: $email);
            $this->remember->handle(email: $email, code: $code);
        });
    }
}
