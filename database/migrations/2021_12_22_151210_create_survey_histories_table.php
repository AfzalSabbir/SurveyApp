<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_survey_id')->constrained('user_surveys')->cascadeOnDelete();
            $table->foreignId('survey_item_id')->constrained('survey_items')->cascadeOnDelete();
            $table->text('survey_value');
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
        Schema::dropIfExists('survey_histories');
    }
}
