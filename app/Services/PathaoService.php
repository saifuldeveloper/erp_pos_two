<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PathaoService
{
    protected string $baseUrl;
    protected string $token;

    public function __construct(protected array $credentials)
    {
        $this->baseUrl = 'https://courier-api-sandbox.pathao.com';
        $this->token = $this->getToken();
    }


    protected function getToken(): string
    {

        $response = Http::withHeaders([
            'Accept' => 'application/json'
        ])
            ->withBody(json_encode([
                'client_id' => trim($this->credentials['client_id']),
                'client_secret' => trim($this->credentials['client_secret']),
                'grant_type' => 'password',
                'username' => trim($this->credentials['username']),
                'password' => trim($this->credentials['password']),
            ]), 'application/json')
            ->post($this->baseUrl . '/aladdin/api/v1/issue-token');

        if (!$response->ok()) {
            throw new \Exception('Pathao token error: ' . $response->body());
        }
        return $response->json('access_token');
    }

    protected function headers(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ];
    }

    public function getCityIdByName(string $cityName): ?int
    {
        
        $response = Http::withHeaders($this->headers())
            ->get($this->baseUrl . '/aladdin/api/v1/city-list');

        if (!$response->ok()) {
            throw new \Exception('Failed to fetch cities: ' . $response->body());
        }

        $citiesData = $response->json('data');
        $cities =$citiesData['data'];
     
        $city = collect($cities)->first(function ($item) use ($cityName) {

            return strtolower(trim($item['city_name'])) === strtolower(trim($cityName));
        });
        return $city['city_id'] ?? null;
    }


    public function sendOrder(array $data): array
    {

        $response = Http::withHeaders($this->headers())
            ->post($this->baseUrl . '/aladdin/api/v1/orders', $data);

        $result = json_decode($response);
        if (!$response->ok()) {
            throw new \Exception($response->json('message') ?? 'Pathao order failed');
        }

        return $response->json();
    }
}
