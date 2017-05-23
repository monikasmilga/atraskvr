<?php
/**
 * Created by PhpStorm.
 * User: karolis
 * Date: 5/17/2017
 * Time: 9:49 AM
 */

namespace App\Console\Commands;

use App\Models\VRUsers;
use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid;

class CreateAdministrator extends Command
{
    protected $signature = "make:admin";

    protected $description = "Create admin user account";

    public function handle()
    {
        if(VRUsers::get()->toArray() == [])
        {
            $this->comment("Creating admin user");

            $record = VRUsers::create([
                'id' => Uuid::uuid4(),
                'name' => $name = $this->ask('Please provide name'),
                'surname' => 'pavarde',
                'email' => $email = $this->ask('Please provide email'),
                'phone' => 86868686,
                'password' => bcrypt($password = $this->secret('Please provide password')),
            ]);

            $record -> connection()-> sync('super-admin');

            $this->comment("Great success!");

        } else {

            $this->comment("Super admin user already exists");
        }
    }
}