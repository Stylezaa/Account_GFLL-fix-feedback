<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Currency;
use Illuminate\Support\Facades\Validator;
use Alert;

class CurrencyController extends Controller
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

	public function getCurrency(Request $request){

		$currency = Currency::where('stoped', 0)->get();
		
		return response()->json($currency);

    }
}
