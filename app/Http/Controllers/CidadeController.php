<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\CidadeServiceInterface;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Class CidadeController
 * @package App\Http\Controllers
 */
class CidadeController extends Controller
{
    private $city;

    public function __construct(CidadeServiceInterface $cityInterface)
    {
        $this->city = $cityInterface;
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
            return response()->json(
                [
                    $e->getMessage()
                ],
                400
            );
        }
    }
}
