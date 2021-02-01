<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubnetIpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subnet_ips', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('subnet_ip_address');

            $table->string('ip');

            $table->enum('status', ['created', 'used', 'unused'])->default('created');

            $table->float('response_time')->default(0.0);

            $table->string('comment')->nullable();

            $table->timestamps();

            $table->foreign('subnet_ip_address')->references('id')->on('subnet_infos')->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subnet_ips');
    }
}
