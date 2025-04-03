<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

class ConfigController extends Controller
{
    #[OA\Get(
        path: "/config",
        summary: "Konfiguracioni fajl blog",
        tags: ["Config"],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: "Sve postojeće konfiguracije"),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: "Server Error")
        ]
    )]
    public function index(): JsonResponse
    {
        return response()->json(
            config('blog')
        );
    }

    #[OA\Get(
        path: "/config/{code}",
        summary: "Pojedinačni konfiguracioni podatak",
        description: "order_models, order_names, config_substation_status, config_order_types, config_user_types, config_metalwork, config_order_status, config_signal_score, config_substation_type, config_nfc_lock_type",
        parameters: [new OA\Parameter(parameter:'code', name: 'code', description: 'naziv pojeninačnog šifarnika', in: 'path', required:true)],
        tags: ["Config"],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: "Pojedinačni konfiguracioni podatak"),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: "Server Error")
        ]
    )]
    public function code($code): JsonResponse
    {
        $code = config('blog.' . $code);
        if($code) {
            return response()->json(
                $code
            );
        }
        return response()->json([
            'message' => 'Ne postoji zadati termin'
        ], 404);
    }
}
