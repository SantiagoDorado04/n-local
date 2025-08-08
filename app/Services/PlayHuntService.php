<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class PlayHuntService
{
    protected $baseUrl;
    protected $accessToken;

    public function __construct()
    {
        $this->baseUrl = 'https://api.playhunt.io/public/1.00/';
        $this->accessToken = env('PLAYHUNT_API');
    }

    public function request($endpoint, $params = [])
    {
        $response = Http::withHeaders([
            'access-token' => $this->accessToken,
        ])->post($this->baseUrl . $endpoint, $params);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Error: ' . $response->body());
    }

    public function getInterview($guid)
    {
        return $this->request('interview/get-interview', ['guid' => $guid]);
    }

    public function editInterview($guid, $topic, $questions)
    {
        $params = [
            'guid' => $guid,
            'topic' => $topic,
            'questions' => json_encode($questions),
        ];

        return $this->request('interview/edit-interview', $params);
    }

    public function getInterviewResponse($guid)
    {
        $params = [
            'guid' => $guid,
        ];

        return $this->request('interview-response/get-by-interview-guid', $params, true);
    }

    public function createInterview($topic, $questions)
    {
        $params = [
            'topic' => $topic,
            'questions' => json_encode($questions),
        ];

        return $this->request('interview/create-interview', $params);
    }

    public function deleteInterview($guid)
    {
        $params = [
            'guid' => $guid,
        ];

        return $this->request('interview/delete-interview', $params);
    }

    public function getWhiteLabels()
    {
        return $this->request('white-label/get-all-white-label-configs');
    }
}