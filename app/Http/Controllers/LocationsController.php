<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;

class LocationsController extends Controller
{
    /**
     * Get all locations
     * 
     * @response array<array{
     *   region: string,
     *   state?: string ,
     *   city?: string,
     * }>
     */
    public function getLocations(Request $request)
    {
        $user = $request->user();
        
        $districts = Cache::remember('ibge_districts', 3600, function () {
            $response = Http::get('https://servicodados.ibge.gov.br/api/v1/localidades/distritos');

            if ($response->failed()) {
                abort(400, 'Failed to fetch data from IBGE API');
            }
            return $response->json();
        });

        $filtered = [];

        foreach ($districts as $district) {
            $region = $district['municipio']['microrregiao']['mesorregiao']['UF']['regiao']['nome'];
            $state = $district['municipio']['microrregiao']['mesorregiao']['UF']['nome'];
            $city = $district['municipio']['nome'];

            if (Gate::allows('accessCities', $user)) {
                $filtered[] = [
                    'region' => $region,
                    'state' => $state,
                    'city' => $city,
                ];
            } elseif (Gate::allows('accessStates', $user)) {
                if (!in_array($state, array_column($filtered, 'state'))) {
                    $filtered[] = [
                        'region' => $region,
                        'state' => $state,
                    ];
                }
            } elseif (Gate::allows('accessRegions', $user)) {
                if (!in_array($region, array_column($filtered, 'region'))) {
                    $filtered[] = [
                        'region' => $region,
                    ];
                }
            }
        }

        return response()->json($filtered);
    }
}
