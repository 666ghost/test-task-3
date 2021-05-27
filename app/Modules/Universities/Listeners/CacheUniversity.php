<?php


namespace App\Modules\Universities\Listeners;


use App\Modules\Universities\Events\UniversitySaved;
use App\Modules\Universities\Models\UniversityKey;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Class CacheUniversity
 * @package App\Modules\Universities\Listeners
 */
class CacheUniversity implements ShouldQueue
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param UniversitySaved $event
     */
    public function handle(UniversitySaved $event)
    {
        $this->saveToCache($event->universityKey, $event->data);
    }


    /**
     * @param UniversityKey $universityKey
     * @param array $data
     * @return void
     */
    private function saveToCache(UniversityKey $universityKey, array $data): void
    {
        $expiresAt = Carbon::now()->addSeconds(rand(5 * 60, 15 * 60));
        $data['expires_at'] = $expiresAt->timestamp;

        Cache::put($universityKey->key, $data, $expiresAt);
    }
}
