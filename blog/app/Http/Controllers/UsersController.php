<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['validateAdmin'])->only(['verified', 'unverified', 'verify']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Display a listing of the verified users.
     */
    public function verified()
    {
        $users = User::verified()->paginate(10);
        return view('admin.users.verified', compact('users'));
    }

    /**
     * Display a listing of the unverified users.
     */
    public function unverified()
    {
        $users = User::unverified()->paginate(10);
        return view('admin.users.unverified', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the email verified date in storage.
     */
    public function verify(User $user)
    {
        $user->email_verified_at = Carbon::now();
        $user->save();

        session()->flash('success', 'User Verified successfully');
        return redirect(route('admin.users.verified'));
    }

    public function makeAdmin(User $user)
    {
        $user->role = 'admin';
        $user->save();

        session()->flash('success', "$user->name has been assigned the role of Admin");
        return redirect(route('admin.users.verified'));
    }

    public function revokeAdmin(User $user)
    {
        $user->role = 'author';
        $user->save();

        session()->flash('success', "$user->name has been assigned the role of Author");
        return redirect(route('admin.users.verified'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
