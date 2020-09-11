<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;


class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    function index(Request $request)
    {
        if ($request->ajax()) {

            if (!empty($request->from_date)) {
                $data = User::whereBetween('dob', array($request->from_date, $request->to_date))
                    ->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->make(true);
            }

            $data = User::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('home');
    }
}
