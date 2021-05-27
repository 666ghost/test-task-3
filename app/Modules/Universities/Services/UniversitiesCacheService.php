<?php


namespace App\Modules\Universities\Services;


use App\Modules\Universities\Entities\UniversityKeyEntity;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class UniversitiesCacheService
{

    /**
     * @var UniversityKeyEntity
     */
    private UniversityKeyEntity $universityKeyEntity;

    /**
     * @var UniversitiesApiParser
     */
    private UniversitiesApiParser $universitiesApiParser;

    /**
     * UniversityController constructor.
     * @param UniversityKeyEntity $universityKeyEntity
     */
    public function __construct(
        UniversityKeyEntity $universityKeyEntity,
        UniversitiesApiParser $universitiesApiParser
    ) {
        $this->universityKeyEntity = $universityKeyEntity;
        $this->universitiesApiParser = $universitiesApiParser;
    }

    /**
     * @param string|null $searchText
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function findCached(?string $searchText): array
    {
        $universityKeys = $this->universityKeyEntity->findByNameAndDomains($searchText);
        $universities = [];

        foreach ($universityKeys as $universityKey) {
            $universities[] = $this->getCached($universityKey);
        }

        $universitiesPagination = collect($universityKeys)->toArray();
        $universitiesPagination['data'] = $universities;
        return $universitiesPagination;
    }

    /**
     * @param $universityKey
     * @return mixed
     */
    public function getCached($universityKey, bool $update = false)
    {
        if ($update) {
            Cache::forget($universityKey->key);
        }
        $expiresAt = Carbon::now()->addSeconds(rand(5 * 60, 15 * 60));

        return Cache::remember(
            $universityKey->key,
            $expiresAt,
            function () use ($universityKey, $expiresAt) {
                $university = $this->universitiesApiParser->findOneByName($universityKey->name);
                $university['id'] = $universityKey->id;
                $university['expires_at'] = $expiresAt->timestamp;
                return $university;
            }
        );
    }
}
