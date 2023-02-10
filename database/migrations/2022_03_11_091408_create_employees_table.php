<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('position_id')->constrained();
            $table->integer('position_id')->constrained();
            $table->string('name');
            $table->string('nip');
            $table->string('departemen');
            $table->date('date_birth');
            // $table->year('year');
            $table->text('address');
            $table->string('no_telp');
            $table->string('religion');
            $table->boolean('status')->default(1);
            $table->string('image');
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
        Schema::dropIfExists('employees');
    }
}