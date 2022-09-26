<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('email');
            $table->bigInteger('phone')->nullable();
            $table->foreignIdFor(User::class)->nullable();
            $table->text('text');
            $table->json('data');
            $table->timestamps();
            $table->morphs('commentable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
