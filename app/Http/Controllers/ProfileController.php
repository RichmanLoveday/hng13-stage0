<?php

namespace App\Http\Controllers;

use App\Services\CartFactService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected CartFactService $cartFactService;

    public function __construct(CartFactService $cartFactService)
    {
        $this->cartFactService = $cartFactService;
    }


    public function me()
    {
        //? Fetch Cat (Service return fallback string if an error occurs)
        $fact = $this->cartFactService->fetchFact();

        //? time stamp in current UTC IsO 8601 format
        $timestamp = now()->utc()->toIso8601String();

        //? prepare payload
        $payLoad = [
            'status' => 'success',
            'user' => [
                'email' => 'lovedayrichman@yahoo.com',
                'name' => 'Richman Loveday',
                'stack' => 'Laravel 11',
            ],
            'fact' => $fact,
            'timestamp' => $timestamp,
        ];


        //? return response json
        return response()->json($payLoad, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}
