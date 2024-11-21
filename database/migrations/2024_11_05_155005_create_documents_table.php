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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date') ;
            $table->text('nots')->nullable();
            $table->enum('type', [1,2,3,4]);
            //صادر الي داخلي  =1         issued-internal
            //صادر الي خارجي = 2         issued-external
            //وارد من داخلي = 3         incoming-internal
            //وارد من خارجي = 4         incoming-external

            $table->unsignedBigInteger('branch_id');  // auth branch
            $table->unsignedBigInteger('entity_id');
            $table->unsignedBigInteger('created_by')->nullable();

            $table->foreign('branch_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('entity_id')->references('id')->on('entities');
            $table->foreign('created_by')->references('id')->on('users'); // No onDelete rule
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            // Drop foreign keys
            $table->dropForeign(['entity_id']);
            $table->dropForeign(['created_by']);
        });
        Schema::dropIfExists('documents');
    }
};
