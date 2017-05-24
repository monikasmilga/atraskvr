<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToVrPagesResourcesConnectionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('vr_pages_resources_connections', function(Blueprint $table)
		{
			$table->foreign('pages_id', 'fk_vr_pages_resources_connections_vr_pages1')->references('id')->on('vr_pages')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('resources_id', 'fk_vr_pages_resources_connections_vr_resources1')->references('id')->on('vr_resources')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('vr_pages_resources_connections', function(Blueprint $table)
		{
			$table->dropForeign('fk_vr_pages_resources_connections_vr_pages1');
			$table->dropForeign('fk_vr_pages_resources_connections_vr_resources1');
		});
	}

}
