<?php


use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$adminRole = Role::where('name', 'Admin')->first();

		$permissions[] = Permission::create([
			'name' => 'gerenciar.usuarios',
			'display_name' => 'Gerenciar Usuários',
			'description' => 'Gerenciar usuários.',
			'removable' => false,
		]);

		$permissions[] = Permission::create([
			'name' => 'atividades.usuarios',
			'display_name' => 'Ver sistema de registro de atividades',
			'description' => 'Ver registro de atividades de todos os usuários.',
			'removable' => false,
		]);

		$permissions[] = Permission::create([
			'name' => 'gerenciar.funcoes',
			'display_name' => 'Gerenciar Funções',
			'description' => 'Gerenciar sistema de funções.',
			'removable' => false,
		]);

		$permissions[] = Permission::create([
			'name' => 'gerenciar.permissoes',
			'display_name' => 'Gerenciar Permissões',
			'description' => 'Gerenciar permissões de funções.',
			'removable' => false,
		]);

		$permissions[] = Permission::create([
			'name' => 'configuracoes.geral',
			'display_name' => 'Atualizar configurações gerais do sistema',
			'description' => '',
			'removable' => false,
		]);

		$permissions[] = Permission::create([
			'name' => 'configuracoes.autenticacao',
			'display_name' => 'Atualizar configurações de autenticação',
			'description' => 'Atualizar configurações do sistema de autenticação e registro.',
			'removable' => false,
		]);

		$permissions[] = Permission::create([
			'name' => 'configuracoes.notificacoes',
			'display_name' => 'Atualizar configurações de notificações',
			'description' => '',
			'removable' => false,
		]);

		foreach($permissions as $permission){
			$adminRole->attachPermission($permission);
		}
	}
}
