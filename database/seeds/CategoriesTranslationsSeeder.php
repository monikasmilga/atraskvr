<?php

use App\Models\VRCategoriesTranslations;
use Illuminate\Database\Seeder;

class CategoriesTranslationsSeeder extends Seeder
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
                ["id" => "vr_id_lt", "categories_id" => "virtualus_kambariai_id", "languages_id" => "lt", "name" => "Virtualus kambariai", "slug" => "vrkambariai"],
                ["id" => "vr_id_en", "categories_id" => "virtualus_kambariai_id", "languages_id" => "en", "name" => "Virtual rooms", "slug" => "vrrooms"],

            ];
            DB::beginTransaction();
            try {
                foreach ($list as $single) {
                    $record = VRCategoriesTranslations::find($single['id']);
                    if(!$record) {
                        VRCategoriesTranslations::create($single);
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
