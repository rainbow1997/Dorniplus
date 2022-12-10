<?php

use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->renameColumn('name', 'fname');
            $table->string('lname');
            $table->bigInteger('national_code')->unique();
            $table->bigInteger('phone');
            $table->date('birth');
            $table->enum('gender', ['male', 'female']);
            $table->enum('military_status', ['done', 'doing', 'temporary-exemption', 'permanent-exemption']);
            $table->string('avatar');


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
