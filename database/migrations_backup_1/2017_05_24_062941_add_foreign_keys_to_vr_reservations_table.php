<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToVrReservationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('vr_reservations', function(Blueprint $table)
		{
			$table->foreign('orders_id', 'fk_vr_reservation_vr_order1')->references('id')->on('vr_orders')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('pages_id', 'fk_vr_reservation_vr_pages1')->references('id')->on('vr_pages')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('vr_reservations', function(Blueprint $table)
		{
			$table->dropForeign('fk_vr_reservation_vr_order1');
			$table->dropForeign('fk_vr_reservation_vr_pages1');
		});
	}

}
