<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToVrUsersRolesConnectionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('vr_users_roles_connections', function(Blueprint $table)
		{
			$table->foreign('roles_id', 'fk_vr_users_roles_connections_vr_roles1')->references('id')->on('vr_roles')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('users_id', 'fk_vr_users_roles_connections_vr_users1')->references('id')->on('vr_users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('vr_users_roles_connections', function(Blueprint $table)
		{
			$table->dropForeign('fk_vr_users_roles_connections_vr_roles1');
			$table->dropForeign('fk_vr_users_roles_connections_vr_users1');
		});
	}

}
