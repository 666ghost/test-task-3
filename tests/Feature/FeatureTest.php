<?php


namespace Tests\Feature;


use App\Modules\Universities\Entities\UniversityKeyEntity;
use App\Modules\Universities\Services\UniversitiesApiParser;
use Tests\TestCase;

/**
 * Class FeatureTest
 * @package Tests\Feature
 */
class FeatureTest extends TestCase
{

    /** @test */
    public function it_can_fetch_country_universities()
    {
        /** @var UniversitiesApiParser $universityApiParser */
        $universityApiParser = app(UniversitiesApiParser::class);
        $universities = $universityApiParser->parse('France');

        $this->assertIsArray($universities);
        $this->assertGreaterThan(0, count($universities));
    }


    /** @test */
    public function it_can_store_country_universities()
    {
        /** @var UniversitiesApiParser $universityApiParser */
        $universityApiParser = app(UniversitiesApiParser::class);
        $universityApiParser->parse('France');

        /** @var UniversityKeyEntity $universityKeyEntity */
        $universityKeyEntity = app(UniversityKeyEntity::class);

        $this->assertDatabaseCount('university_keys', 267);
    }
}
