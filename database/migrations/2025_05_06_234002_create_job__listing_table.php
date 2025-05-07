<?php

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

        Schema::dropIfExists('job_listings');

        Schema::create('job_listings', function (Blueprint $table) {


            $table->unsignedBigInteger('user_id')->after('id');
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->integer('salary');
            $table->string('tags')->nullable();
            $table->enum('job_type',['Full-Time', 'Part-Time', 'Contract', 'Temporary', 'Volunteer',
            'Internship', 'On-Call'])->default('Full-Time');
            $table->boolean('remote')->default(false);
            $table->text('requirements')->nullable();
            $table->string('benefits')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('zipcode')->nullable();
            $table->string('contact_email');
            $table->string('contact_phone')->nullable();
            $table->string('company_name');
            $table->text('company_description')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('company_website')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');


            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};