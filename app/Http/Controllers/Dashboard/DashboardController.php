<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Activity\ActivityRepository;
use App\Repositories\User\UserRepository;
use App\Support\Enum\UserStatus;
use Carbon\Carbon;

class DashboardController extends Controller {

	private $users;

	private $activities;


	public function __construct(UserRepository $users, ActivityRepository $activities) {
		$this->users = $users;
		$this->activities = $activities;
	}


	public function index() {
		return $this->adminDashboard();
	}


	private function adminDashboard() {
		$usersPerMonth = $this->users->countOfNewUsersPerMonth(
			Carbon::now()->startOfYear(),
			Carbon::now()
		);

		$stats = [
			'total' => $this->users->count(),
			'new' => $this->users->newUsersCount(),
			'banned' => $this->users->countByStatus(UserStatus::BANNED),
			'unconfirmed' => $this->users->countByStatus(UserStatus::UNCONFIRMED),
		];

		$latestRegistrations = $this->users->latest(8);

		return view('dashboard.admin', compact('stats', 'latestRegistrations', 'usersPerMonth'));
	}

}