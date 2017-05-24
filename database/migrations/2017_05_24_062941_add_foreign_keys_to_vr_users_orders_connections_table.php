<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToVrUsersOrdersConnectionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('vr_users_orders_connections', function(Blueprint $table)
		{
			$table->foreign('orders_id', 'fk_vr_pages_resources_connections_copy1_vr_order1')->references('id')->on('vr_orders')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('users_id', 'fk_vr_pages_resources_connections_copy1_vr_users1')->references('id')->on('vr_users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('vr_users_orders_connections', function(Blueprint $table)
		{
			$table->dropForeign('fk_vr_pages_resources_connections_copy1_vr_order1');
			$table->dropForeign('fk_vr_pages_resources_connections_copy1_vr_users1');
		});
	}

}
