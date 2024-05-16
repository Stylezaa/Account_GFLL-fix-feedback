<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Level;
use Illuminate\Support\Facades\Validator;
use Alert;

class LevelController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function getLevel(Request $request)
	{

		$level = Level::get();

		return response()->json($level);
	}
}
