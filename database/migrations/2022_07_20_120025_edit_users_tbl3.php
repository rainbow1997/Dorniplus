<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Province;
use App\Models\City;
class EditUsersTbl3 extends Migration
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
            $table->foreignIdFor(Province::class)->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->foreignIdFor(City::class)->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->text('avatar')->nullable()->change();
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
