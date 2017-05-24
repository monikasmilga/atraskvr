<?php

use App\Models\VRPagesCategories;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
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
                ["id" => "virtualus_kambariai_id"],

            ];
            DB::beginTransaction();
            try {
                foreach ($list as $single) {
                    $record = VRPagesCategories::find($single['id']);
                    if(!$record) {
                        VRPagesCategories::create($single);
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
