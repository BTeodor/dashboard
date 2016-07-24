<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Activity\ActivityRepository;
use App\Models\User;
use Illuminate\Http\Request;


class ActivityController extends Controller {

	private $activities;


	public function __construct(ActivityRepository $activities) {
		$this->activities = $activities;
	}


	public function index(Request $request) {
		$perPage = 20;
		$adminView = true;

		$activities = $this->activities->paginateActivities($perPage, $request->get('search'));

		return view('dashboard.activity.index', compact('activities', 'adminView'));
	}


	public function userActivity($user_id, Request $request) {
		$user = User::find($user_id);
		$perPage = 20;
		$adminView = true;

		$activities = $this->activities->paginateActivitiesForUser(
			$user->id, $perPage, $request->get('search')
		);

		return view('dashboard.activity.index', compact('activities', 'user', 'adminView'));
	}
}
