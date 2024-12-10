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
        Schema::create('event_ticket_groups', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id')->unsigned();
            $table->string('name');
            $table->integer('tickets_per_user')->unsigned();
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });

        Schema::table('event_tickets', function(Blueprint $table) {
            $table->integer('event_ticket_group_id')->unsigned()->nullable()->after('no_tickets_per_user');
            $table->foreign('event_ticket_group_id')->references('id')->on('event_ticket_groups')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_tickets', function (Blueprint $table) {
            $table->dropForeign('event_tickets_event_ticket_group_id_foreign');
            $table->dropColumn('event_ticket_group_id');
        });

        Schema::drop('event_ticket_groups');
    }
};
