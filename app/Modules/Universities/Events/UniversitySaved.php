<?php


namespace App\Modules\Universities\Events;

use App\Modules\Universities\Models\UniversityKey;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * Class UniversitySaved
 * @package App\Modules\Universities\Events
 */
class UniversitySaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    /**
     * @var UniversityKey
     */
    public UniversityKey $universityKey;

    /**
     * @var array
     */
    public array $data;

    /**
     * UniversitySaved constructor.
     * @param UniversityKey $universityKey
     * @param array $data
     */
    public function __construct(UniversityKey $universityKey, array $data)
    {
        $this->universityKey = $universityKey;
        $this->data = $data;
    }
}
