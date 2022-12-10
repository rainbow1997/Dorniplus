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
            $table->string('fullname')->fulltext();
            $table->string('email')->fulltext();
            $table->bigInteger('phone')->nullable()->index();
            $table->foreignIdFor(User::class)->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->text('text')->fulltext();
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
