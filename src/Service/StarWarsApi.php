<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Utils;

class StarWarsApi
{
    private const COLLECTION = 'COLLECTION';
    private const ITEM = 'ITEM';
    private const BASE_URL = 'https://swapi.py4e.com/api/people/';

    public function __construct(
        private HttpClientInterface $httpClient,
    ) {
    }

    private function makeRequest(string $type, ?int $id = null): array
    {
        $url = $id ? self::BASE_URL . $id : self::BASE_URL;
        $response = $this->httpClient->request('GET', $url);

        if ($type === self::COLLECTION) {
            $data = $response->toArray()['results'];

            while (Utils::getArrayValue('next', $response->toArray())) {
                $next = $response->toArray()['next'];
                $response = $this->httpClient->request('GET', $next);
                $data = array_merge($data, $response->toArray()['results']);
            }

            foreach ($data as $key => $personnage) {
                $randomId = rand(1, 50);
                $data[$key]['photo'] = 'https://i.pravatar.cc/300?img=' . $randomId;
            }
        }

        if ($type === self::ITEM) {
            $data = $response->toArray();
            $randomId = rand(1, 50);
            $data['photo'] = 'https://i.pravatar.cc/300?img=' . $randomId;
        }

        return $data;
    }

    public function getPersonnages(): array
    {
        return $this->makeRequest(self::COLLECTION);
    }
    public function getPersonnage(int $id): array
    {
        return $this->makeRequest(self::ITEM, $id);
    }
}
