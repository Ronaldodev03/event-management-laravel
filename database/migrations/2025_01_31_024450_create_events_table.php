<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            //way one:
            //$table->unsignedBigInteger('user_id'); 
            //$table->foreign('user_id')->references('id')->on('users');
            //note: The unsignedBigInteger('user_id') is a lower-level way to create the foreign key column that foreignIdFor() does for you automatically. 
            //      unsigned: Means the column can only store positive numbers (no negative values); 
            //      BigInteger: Creates a BIGINT column in the database (8 bytes); 
            //      user_id: The name of the column being created.
            
            //way two:
            //$table->foreignId('user_id')->constrained();

            //way three:
            $table->foreignIdFor(User::class); //hace lo mismo que way one and two --> tiene que ver con la relacion uno a muchos --> hay metodos en los models

            $table->string('name');
            $table->text('description')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
