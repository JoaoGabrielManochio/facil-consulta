<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\CidadeServiceInterface;
use App\Services\Interfaces\LogErrorServiceInterface;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Class CidadeController
 * @package App\Http\Controllers
 */
class CidadeController extends Controller
{
    private $city;
    private $logError;

    public function __construct(
        CidadeServiceInterface $cityInterface,
        LogErrorServiceInterface $logErrorInterface
    ) {
        $this->city = $cityInterface;
        $this->logError = $logErrorInterface;
    }

    /**
     * Return a list of citys
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function list(): JsonResponse
    {
        try {
            return response()->json(
                $this->city->listCitys()
            );
        } catch (Exception $e) {

            $params = [
                'route' => 'cidades.list',
                'error' => $e
            ];

            $this->logError->storeLog($params);

            return response()->json(
                [
                   'Algo inesperado ocorreu, tente novamente ou entre em contato via e-mail'
                ],
                400
            );
        }
    }
}
