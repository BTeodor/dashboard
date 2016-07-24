<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Role::create([
			'name' => 'Admin',
			'display_name' => 'Admin',
			'description' => 'Administrador do sistema.',
			'removable' => false,
		]);

		Role::create([
			'name' => 'Usuario',
			'display_name' => 'Usuario',
			'description' => 'Usuário padrão do sistema.',
			'removable' => false,
		]);
	}
}
