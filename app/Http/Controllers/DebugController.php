<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DebugController extends Controller
{
    public function showUsers()
    {
        $users = User::all();
        $users->makeVisible('password');
        
        // Return as JSON
        if (request()->wantsJson()) {
            return response()->json([
                'users' => $users,
                'count' => $users->count()
            ]);
        }
        
        // Return as HTML
        return view('debug.users', ['users' => $users]);
    }
    
    public function showUser($email)
    {
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            if (request()->wantsJson()) {
                return response()->json(['error' => 'User not found'], 404);
            }
            abort(404, 'User not found');
        }
        
        $user->makeVisible('password');
        
        if (request()->wantsJson()) {
            return response()->json($user);
        }
        
        return view('debug.user', ['user' => $user]);
    }
    
    // Show all users in a simple table
    public function showUsersTable()
    {
        $users = User::all();
        $users->makeVisible('password');
        
        return view('debug.users-table', ['users' => $users]);
    }
}