<?php

namespace App\Utils;

use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseFormat
{
    /**
     * Fonction qui retourne une réponse JSON dans un format standard d'API.
     *
     * @param mixed|null $data       Les données à renvoyer dans la réponse.
     * @param int $statusCode   Le code de statut HTTP (par défaut 200).
     * @param mixed|null $error Le message d'erreur, si présent (par défaut null) et aussi d'autre detail.
     * @param mixed|null $meta  Les métadonnées supplémentaires, si présentes (par défaut null).
     * @return JsonResponse
     */
    public static function createApiResponse($data = null, int $statusCode = 200,$error = null, $meta = null): JsonResponse
    {
        // Construire la structure de la réponse
        $response = [
            'status' => $error ? 'error' : 'success',
            'data' => $data,
            'error' => $error,
            'meta' => $meta,
        ];

        // Retourner la réponse JSON avec le code de statut HTTP approprié
        return new JsonResponse($response, $statusCode);
    }
}
