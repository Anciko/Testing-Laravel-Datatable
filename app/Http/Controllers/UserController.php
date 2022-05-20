<?php

namespace App\Http\Controllers;

use App\Models\User;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('welcome', compact('users'));
    }

    public function ssd()
    {
        $users = User::with('city')->get();
        // dd($users->toArray());

        return DataTables::of($users)
            ->editColumn('name', function ($user) {
                return "<span class='badge badge-secondary'>" . $user->name . "</span>";
            })
            ->addColumn('action', function ($user) {
                return "<a href='' class='btn btn-danger btn-sm delete' data-id= ' $user->id '>Delete</a>";
            })
            ->addColumn('city', function($user) {
                return $user->city->name;
            })
            ->rawColumns(['name', 'action'])
            ->make(true);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return true;
    }
}
