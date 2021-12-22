<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_items', function (Blueprint $table) {
            $table->id();
            $table->string('title', 191);
            $table->foreignId('input_type_id')->constrained('input_types');
            $table->foreignId('survey_step_id')->constrained('survey_steps');
            $table->boolean('is_multiple');
            $table->text('options')->nullable()->comment('comma(,) separable');
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
        Schema::dropIfExists('survey_items');
    }
}
