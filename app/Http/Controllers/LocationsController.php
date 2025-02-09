<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Gate;

class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

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

        $response = Http::get('https://servicodados.ibge.gov.br/api/v1/localidades/distritos');

        if ($response->failed()) {
            return response()->json(['message' => 'Failed to fetch data from IBGE API'], 400);
        }

        $districts = $response->json();

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
