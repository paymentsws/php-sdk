<?php

namespace PaymentsWs;

class TokenService
{

    /**
     * @var PaymentsWs Client
     */
    private $client;

    /**
     * TokenService constructor.
     *
     * @param TokenService $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * Tokenizes data.
     *
     * @param  any $data (String or object)
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function tokenize($data)
    {
        $json = ['data' => $data];
        return $this->client->post('tokens/create', $json);
    }

    /**
     * Detokenizes data.
     *
     * @param  string $token
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function detokenize($token)
    {
        $json = null;
        return $this->client->put("tokens/{$token}/detokenize", $json);
    }

    /**
     * Validate if token exists and is valid.
     *
     * @param  string $token
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function validate($token)
    {
        $json = null;
        return $this->client->put("tokens/{$token}/validate", $json);
    }

    /**
     * Deletes the token an its associated encrypted data.
     *
     * @param  string $token
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete($token)
    {
        $json = null;
        return $this->client->delete("tokens/{$token}", $json);
    }

}
