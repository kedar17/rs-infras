<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalsTableskedar extends Migration
{
    public function up()
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('reference');
            $table->string('client_name');
            $table->text('client_address');
            $table->string('client_mobile');
            $table->string('subject');
            $table->text('body_intro');
            $table->json('items');
            $table->decimal('price_total', 12, 2);
            $table->unsignedTinyInteger('price_gst_percent');
            $table->string('price_in_words');
            $table->json('scope_of_work');
            $table->json('warranty');
            $table->json('payment_schedule');
            $table->json('notes')->nullable();
            $table->string('signatory_name');
            $table->string('signatory_role');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('proposals');
    }
}