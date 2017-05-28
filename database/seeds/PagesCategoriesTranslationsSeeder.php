<?php

use App\Models\VRCategoriesTranslations;
use App\Models\VRPagesCategoriesTranslations;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagesCategoriesTranslationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $list = [
                ["id" => "vr_id_lt", "categories_id" => "vr_categories_id", "languages_id" => "lt", "name" => "Virtualus kambariai", "slug" => "vrkambariai"],
                ["id" => "vr_id_en", "categories_id" => "vr_categories_id", "languages_id" => "en", "name" => "Virtual rooms", "slug" => "vrrooms"],

            ];
            DB::beginTransaction();
            try {
                foreach ($list as $single) {
                    $record = VRPagesCategoriesTranslations::find($single['id']);
                    if(!$record) {
                        VRPagesCategoriesTranslations::create($single);
                    }
                }
            } catch(Exception $e) {
                DB::rollback();
                throw new Exception($e);
            }
            DB::commit();

        }
    }
}
