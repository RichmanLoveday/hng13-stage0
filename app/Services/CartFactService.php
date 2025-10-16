<?php

namespace App\Services;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CartFactService
{
    protected string $baseUrl;
    protected int $timeout;

    public function __construct()
    {
        $this->baseUrl = config('services.cartfact.url', env('CATFACT_API_URL'));
        $this->timeout = (int) config('services.cartfact.timeout', env('CATFACT_TIMEOUT', 5));
    }


    public function fetchFact()
    {
        try {
            //? access cartfact api to get a fact
            $response = Http::timeout($this->timeout)
                ->get($this->baseUrl);


            //? check if response if successfull and fact is present
            if ($response->successful() && isset($response['fact'])) {
                return $response['fact'];       //? return the fact if successfull or return string error message
            }

            //? log error warning message
            Log::warning("CartFactService: could not fetch fact", [
                'status' => $response->status(),
                'response' => $response->body(),
            ]);

            return "Could not fecth fact at the moment";
        } catch (\Exception $e) {
            Log::error("CartFactService: error fetching fact", [
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
            ]);

            return "Could not fecth fact at the moment";
        }
    }
}
