<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Province;
use App\Models\City;
class EditUsersTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->renameColumn('name','fname');
            $table->string('lname');
            $table->bigInteger('national_code');
            $table->bigInteger('phone');
            $table->date('birth');
            $table->enum('gender',['male','female']);
            $table->enum('military_status',['done','doing','temporary-exemption','permanent-exemption']);
            $table->string('avatar');
            $table->foreignIdFor(Province::class);
            $table->foreignIdFor(City::class);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
