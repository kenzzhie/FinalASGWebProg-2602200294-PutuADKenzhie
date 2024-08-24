<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentUserID = Auth::user()->id;
    $friendRequests = FriendRequest::where('receiver_id', $currentUserID)
        ->where('status', 'pending')
        ->join('users', 'users.id', '=', 'friend_requests.sender_id')
        ->get(['friend_requests.id as request_id', 'users.*']);
        $loc = session()->get('locale');
        \App::setLocale($loc);
        return view('request', compact('friendRequests'));
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
        $sender_id = Auth::user()->id;
        $receiver_id = $request->input('receiver_id');

        $friendRequest = FriendRequest::create([
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id
        ]);

        $loc = session()->get('locale');
        \App::setLocale($loc);

        if ($friendRequest) {
            return redirect()->route('user.index')->with('success', 'Friend request sent');
        }
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
    public function destroy($id)
{
    $deleteRequest = FriendRequest::find($id);
    if ($deleteRequest) {
        $deleteRequest->delete();
    }

    $loc = session()->get('locale');
    \App::setLocale($loc);

    return redirect()->route('friend-request.index')->with('success', 'Successfully deleted');
}

public function accept(Request $request)
{
    $request_id = $request->input('request_id');
    $friend_id = $request->input('friend_id');

    // Find the friend request and update status
    $friendRequest = FriendRequest::find($request_id);
    if ($friendRequest) {
        $friendRequest->status = 'accepted';
        $friendRequest->save();

        // Optionally, you can add logic to create a friendship record here
        // e.g., Friends::create(['user_id' => Auth::id(), 'friend_id' => $friend_id]);

        return redirect()->route('friend-request.index')->with('success', 'Friend request accepted');
    }

    return redirect()->route('friend-request.index')->with('error', 'Friend request not found');
}


}
