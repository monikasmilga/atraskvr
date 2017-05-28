<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToVrRolesPermissionsConnectionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('vr_roles_permissions_connections', function(Blueprint $table)
		{
			$table->foreign('permissions_id', 'fk_vr_roles_permissions_connections_vr_permissions1')->references('id')->on('vr_permissions')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('roles_id', 'fk_vr_roles_permissions_connections_vr_roles1')->references('id')->on('vr_roles')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('vr_roles_permissions_connections', function(Blueprint $table)
		{
			$table->dropForeign('fk_vr_roles_permissions_connections_vr_permissions1');
			$table->dropForeign('fk_vr_roles_permissions_connections_vr_roles1');
		});
	}

}
