<?php

namespace App\Models;


use Illuminate\Support\Facades\Config;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table;

	protected $casts = [
		'removable' => 'boolean',
	];

	/**
	 * Creates a new instance of the model.
	 *
	 * @param array $attributes
	 */
	public function __construct(array $attributes = []) {
		parent::__construct($attributes);
		$this->table = Config::get('entrust.roles_table');
	}

	protected $fillable = ['name', 'display_name', 'description', 'removable'];
}