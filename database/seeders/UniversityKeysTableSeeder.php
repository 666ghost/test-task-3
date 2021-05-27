<?php


namespace Database\Seeders;


use App\Modules\Universities\Entities\UniversityKeyEntity;
use Illuminate\Database\Seeder;
use App\Modules\Universities\Services\UniversitiesApiParser;

/**
 * Class UniversityKeysTableSeeder
 * @package Database\Seeders
 */
class UniversityKeysTableSeeder extends Seeder
{
    /**
     * @var UniversitiesApiParser $universitiesApiParser
     */
    private UniversitiesApiParser $universitiesApiParser;

    /**
     * @var UniversityKeyEntity $universityKeyEntity
     */
    private UniversityKeyEntity $universityKeyEntity;

    /**
     * UniversityKeysTableSeeder constructor.
     * @param UniversitiesApiParser $universitiesApiParser
     */
    public function __construct(UniversitiesApiParser $universitiesApiParser, UniversityKeyEntity $universityKeyEntity)
    {
        $this->universitiesApiParser = $universitiesApiParser;
        $this->universityKeyEntity = $universityKeyEntity;
    }

    /**
     * Seed the application's database.
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function run()
    {
        $this->universityKeyEntity->getModel()->truncate();
        $this->universitiesApiParser->parse();
    }
}
