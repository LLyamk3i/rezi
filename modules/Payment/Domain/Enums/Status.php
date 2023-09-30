<?php

declare(strict_types=1);

namespace Modules\Payment\Domain\Enums;

enum Status: string
{
    case Pending = 'pending';
    case Completed = 'completed';
    case Canceled = 'canceled';
    case Failed = 'failed';
}
