<?php

namespace RecursiveTree\Seat\WandererAccessSync\Driver;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class WandererAccessList
{
    private string $id;
    private string $token;
    private Collection $members;

    private Client $client;

    /**
     * @param string $id
     * @param string $token
     * @param Collection $members
     */
    public function __construct(string $id, string $token, string $wanderer_server)
    {
        $this->id = $id;
        $this->token = $token;
        $this->members = collect();

        $this->client = new Client([
            'base_uri' => $wanderer_server
        ]);
    }

    public function seedMembers()
    {
        $response = $this->sendCall('GET', sprintf('/api/acls/%s',$this->id),[]);
        foreach ($response['data']['members'] as $member){
            if(!array_key_exists('eve_character_id',$member)) continue;

            $character_id = (int)$member['eve_character_id'];
            $this->members->add($character_id);
        }
    }

    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(int $character_id): void
    {
        if($this->members->contains($character_id)) return;

        $this->sendCall('POST',sprintf('/api/acls/%s/members',$this->id),[
            'member'=>[
                'eve_character_id' => $character_id,
                'role' => 'member'
            ]
        ]);
    }

    public function deleteMember(int $character_id): void
    {
        if(!$this->members->contains($character_id)) return;

        $this->sendCall('DELETE', sprintf('/api/acls/%s/members/%d',$this->id, $character_id),[]);
    }

    private function sendCall(string $method, string $endpoint, array $arguments)
    {
        $uri = ltrim($endpoint, '/');

        if ($method == 'GET') {
            $response = $this->client->request($method, $uri, [
                'query' => $arguments,
                'headers' => ['Authorization' => 'Bearer ' . $this->token]
            ]);
        } else {
            $response = $this->client->request($method, $uri, [
                'body' => json_encode($arguments, JSON_THROW_ON_ERROR),
                'headers' => ['Authorization' => 'Bearer ' . $this->token, 'Content-Type'=>'application/json']
            ]);
        }

        logger()->debug(
            sprintf(
                '[seat-wanderer-access-sync] [http %d, %s] %s -> /%s',
                $response->getStatusCode(),
                $response->getReasonPhrase(),
                $method,
                $uri
            )
        );

        if ($response->getStatusCode() === 204) {
            return null;
        }

        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }
}