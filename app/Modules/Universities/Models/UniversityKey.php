<?php


namespace App\Modules\Universities\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class UniversityKey
 * @package App\Modules\Universities\Models
 */
class UniversityKey extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['name', 'domains', 'name_domains_unique', 'key'];

}
