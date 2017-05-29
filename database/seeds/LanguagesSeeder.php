<?php

use App\Models\VRLanguages;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesSeeder extends Seeder
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
                ["id" => "lt", "name" => "Lithuanian"],
                ["id" => "en", "name" => "English"]


            ];
            DB::beginTransaction();
            try {
                foreach ($list as $single) {
                    $record = VRLanguages::find($single['id']);
                    if(!$record) {
                        VRLanguages::create($single);
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
