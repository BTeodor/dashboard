<?php

use App\Models\User;
use App\Support\Enum\UserStatus;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder {


	public function run() {
		$faker = Faker::create();

		$user = User::create([
			'first_name' => 'EasyAdmin',
			'last_name' => 'EasyAdmin',
			'username' => 'admin',
			'email' => 'admin@example.com',
			'password' => 'admin123',
			'status' => UserStatus::ACTIVE,
		]);

		$admin = Role::where('name', 'Admin')->first();

		$user->attachRole($admin);
		$user->socialNetworks()->create([]);


		for($i = 0; $i < 10; ++$i){
			$roleuser = Role::where('name', 'Usuario')->first();
			$usercriado = User::create([
				'first_name' => $faker->firstName,
				'last_name' => $faker->lastName,
				'email' => $faker->email,
				'password' => 'teste123',
				'avatar' => null,
				'status' => UserStatus::ACTIVE,
			]);
			$usercriado->attachRole($roleuser);
			$usercriado->socialNetworks()->create([]);
		}

	}
}
