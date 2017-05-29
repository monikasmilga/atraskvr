<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToVrPagesCategoriesTranslationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('vr_pages_categories_translations', function(Blueprint $table)
		{
			$table->foreign('languages_id', 'fk_vr_pages_categories_translations_vr_languages1')->references('id')->on('vr_languages')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('categories_id', 'fk_vr_pages_categories_translations_vr_pages_categories1')->references('id')->on('vr_pages_categories')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('vr_pages_categories_translations', function(Blueprint $table)
		{
			$table->dropForeign('fk_vr_pages_categories_translations_vr_languages1');
			$table->dropForeign('fk_vr_pages_categories_translations_vr_pages_categories1');
		});
	}

}
