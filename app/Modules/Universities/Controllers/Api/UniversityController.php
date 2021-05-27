<?php


namespace App\Modules\Universities\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Modules\Universities\Entities\UniversityKeyEntity;
use App\Modules\Universities\Models\UniversityKey;
use App\Modules\Universities\Services\UniversitiesCacheService;
use Illuminate\Http\Request;

/**
 * Class UniversityController
 * @package App\Modules\Universities\Controllers\Api
 */
class UniversityController extends Controller
{

    /**
     * @var UniversitiesCacheService
     */
    private UniversitiesCacheService $universitiesCacheService;

    /**
     * UniversityController constructor.
     * @param UniversityKeyEntity $universityKeyEntity
     */
    public function __construct(UniversitiesCacheService $universitiesCacheService)
    {
        $this->universitiesCacheService = $universitiesCacheService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function find(Request $request)
    {
        $universities = $this->universitiesCacheService->findCached($request->get('search_text'));

        return response()->json($universities);
    }

    /**
     * @param UniversityKey $universityKey
     * @return mixed
     */
    public function updateCache(UniversityKey $universityKey)
    {
        $universityCache = $this->universitiesCacheService->getCached($universityKey, true);

        return response()->json($universityCache);
    }
}
