<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentUserID = Auth::user()->id;

        // Subquery to get the list of users who have sent a request to the current user
        $sentRequestUserIDs = DB::table('friend_requests')
            ->where('sender_id', '=', $currentUserID)
            ->pluck('receiver_id');

        // Subquery to get the list of users who are already friends
        $friendUserIDs = DB::table('friends')
            ->where('user_id', '=', $currentUserID)
            ->pluck('friend_id');

        // Main query to get users who have not sent a friend request to the current user
        $query = User::where('id', '!=', $currentUserID)
            ->whereNotIn('id', $sentRequestUserIDs)
            ->whereNotIn('id', $friendUserIDs);

        // Search logic: Apply if a search term is provided
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%{$search}%");
        }

        // Filter by hobby if a hobby is selected
        if ($request->has('hobby') && $request->input('hobby') !== 'all') {
            $hobby = $request->input('hobby');
            $query->where('hobby', $hobby);
        }

        // Filter by gender if a gender is selected
        if ($request->has('gender') && $request->input('gender') !== 'all') {
            $gender = $request->input('gender');
            $query->where('gender', $gender);
        }

        $dataUser = $query->get();
        $loc = session()->get('locale');
        \App::setLocale($loc);
        return view('home', compact('dataUser'));
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
