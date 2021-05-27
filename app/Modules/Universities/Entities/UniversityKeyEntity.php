<?php


namespace App\Modules\Universities\Entities;


use App\Entities\ModelEntity;
use App\Modules\Universities\Events\UniversitySaved;
use App\Modules\Universities\Models\UniversityKey;
use Illuminate\Support\Facades\Log;

/**
 * Class UniversityKeyEntity
 * @package App\Modules\Universities\Entities
 */
class UniversityKeyEntity extends ModelEntity
{
    /**
     * @var UniversityKey $model
     */
    protected UniversityKey $model;

    /**
     * @return string
     */
    protected function model(): string
    {
        return UniversityKey::class;
    }

    /**
     * @param array $data
     * @return UniversityKey
     */
    public function save(array $data): UniversityKey
    {
        $key = $this->generateKey($data);
        $universityKey = $this->model->where('key', $key)->first();

        if (!$universityKey) {
            $universityKey = $this->model->create(
                [
                    'key' => $key,
                    'name' => $data['name'],
                    'domains' => implode('', $data['domains'])
                ]
            );
        }

        $data['id'] = $universityKey->id;

        UniversitySaved::dispatch($universityKey, $data);
        return $universityKey;
    }

    /**
     * Generate key by splitting name and domains and
     * @param array $data
     * @return string
     */
    private function generateKey(array $data): string
    {
        return str_replace(
            [' ', "'"],
            '_',
            transliterator_transliterate(
                'Any-Latin; Latin-ASCII; Lower()',
                $data['name'] . '-' . implode('', $data['domains'])
            )
        );
    }

    /**
     * @param string|null $searchText
     */
    public function findByNameAndDomains(?string $searchText)
    {
        if (!$searchText) {
            return $this->model->newQuery()->paginate(10);
        }
        return $this->model->newQuery()
            ->where('name', 'like', "%$searchText%")
            ->orWhere('domains', 'like', "%$searchText%")
            ->paginate(10);
    }
}
