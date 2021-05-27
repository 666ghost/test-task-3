<?php


namespace App\Modules\Universities\Services;


use App\Modules\Universities\Entities\UniversityKeyEntity;
use App\Modules\Universities\Models\UniversityKey;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class UniversitiesApiParser
{
    /**
     * @var UniversityKeyEntity
     */
    private UniversityKeyEntity $universityKeyEntity;

    public function __construct(UniversityKeyEntity $universityKeyEntity)
    {
        $this->universityKeyEntity = $universityKeyEntity;
    }

    /**
     * @param string|null $country
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function parse(string $country = null)
    {
        if (!$country) {
            $country = config('parser.country');
        }

        $client = new Client();

        $response = $client->request(
            'GET',
            'universities.hipolabs.com/search',
            [
                'query' => ['country' => $country]
            ]
        );

        $universities = json_decode($response->getBody(), true);
        $this->saveUniversities($universities);

        return $universities;
    }

    /**
     * @param array $universities
     */
    private function saveUniversities(array $universities)
    {
        foreach ($universities as $university) {
            try {
                $this->universityKeyEntity->save($university);
            } catch (\Exception $exception) {
                Log::warning($exception->getTraceAsString());
            }
        }
    }

    /**
     * @param UniversityKey $universityKey
     * @param string|null $country
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function findOneByName(string $name, string $country = null)
    {
        if (!$country) {
            $country = config('parser.country');
        }

        $client = new Client();

        $response = $client->request(
            'GET',
            'universities.hipolabs.com/search',
            [
                'query' => ['country' => $country, 'name' => $name]
            ]
        );

        $university = json_decode($response->getBody(), true)[0];

        return $university;
    }
}
