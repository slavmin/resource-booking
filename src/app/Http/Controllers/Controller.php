<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="API системы управления бронированием ресурсов",
 *     version="1.0.0",
 *     description="API v1",
 *     @OA\Server(
 *      url="http://localhost/api",
 *      description="Основной сервер API"
 *      )
 * )
 */
abstract class Controller
{
    //
}
