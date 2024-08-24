<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class NotificationController extends Controller
{
    //
    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->find($id);

        if ($notification) {
            $notification->delete();
            return response()->json(['success' => true]);
        }
        $loc = session()->get('locale');
        \App::setLocale($loc);

        return redirect()->back();
    }

}
