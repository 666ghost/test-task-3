<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateUniversityKeysTable
 */
class CreateUniversityKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'university_keys',
            function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('domains');
                $table->unique(['name', 'domains']);
                $table->string('key')->unique();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('university_key');
    }
}
