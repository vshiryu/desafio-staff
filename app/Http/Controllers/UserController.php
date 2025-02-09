<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Show a list of all users.
     * @response User[]
     */
    public function index()
    {
        return response()->json(User::all());
    }

    /**
     * Create a new user.
     * 
     * @unauthenticated
     * 
     * @response User
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'string|in:admin,user',
            'access_level' => 'integer|in:1,2,3',
        ]);

        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);

        return response()->json($user, 201);
    }

    /**
     * Show the specified user.
     * @response User
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Update the specified user.
     * @response User
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => 'sometimes|required|string|max:255',
            'email'    => ['sometimes', 'required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'sometimes|required|string|min:6',
            'role'     => 'sometimes|required|string|in:admin,manager,user',
            'access_level' => 'sometimes|required|integer|in:1,2,3',
        ]);

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);

        return response()->json($user);
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }
}
