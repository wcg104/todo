<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table ->unsignedBigInteger('user_id');
            $table->string('title');
            $table->enum('priority_level',[1,2,3])->default(3);
            $table ->text('tag_id')->nullable();
            $table->enum('status',['pending','completed']);
            $table->boolean('archive')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /** 
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
    }
}
