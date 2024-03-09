<?php

declare(strict_types=1);

namespace Modules\Reservation\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Shared\Domain\Enums\Http;
use Modules\Shared\Domain\UseCases\Response;
use Modules\Shared\Domain\ValueObjects\Ulid;
use Modules\Reservation\Infrastructure\Resources\ReservationResource;
use Modules\Reservation\Infrastructure\Eloquent\Repositories\EloquentReservationRepository;

final class ReservationHistoryController
{
    public function index(EloquentReservationRepository $repository, string $user): JsonResponse
    {
        return new JsonResponse(
            status: Http::OK->value,
            data: [
                'success' => true,
                'message' => trans(key: 'reservation::messages.history.success'),
                'reservations' => $repository->history(owner: new Ulid(value: $user)),
            ],
        );
    }
}
