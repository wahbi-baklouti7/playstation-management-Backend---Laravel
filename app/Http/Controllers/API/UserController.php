<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Models\User;
use App\Traits\ApiRessourceTrait;
use Illuminate\Http\Request;

class UserController extends Controller

{
    use ApiRessourceTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users= User::all();
        return $this->returnData($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {

        $validates = $request->validated();
        $user = User::create($validates);
        return $this->returnData($user,'User created successfully',201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if($user){
        return $this->returnData($user);
        }
        return $this->returnError('User not found',404);


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request ,User $user)
    {

        $validates = $request->validated();
        $user->update($validates);
        return $this->returnData($user,'User updated successfully',200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->successMessage('User deleted successfully');
    }
}
