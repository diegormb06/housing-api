<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableRealStateAddAddressId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('real_states', function (Blueprint $table) {
            $table->foreignId('address_id')->constrained('addresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('real_state', function (Blueprint $table) {
            $table->dropForeign('real_state_address_id_foreign');
            $table->dropColumn('address_id');
        });
    }
}
