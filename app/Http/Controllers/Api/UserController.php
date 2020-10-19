<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @var User
     */
    private $users;

    public function __construct(User $users)
    {
        $this->users = $users;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $all_users = $this->users->all();
        return response()->json($all_users);
    }

    /**
     * Store a newly created user in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        $data = $request->all();

        if(!$request->has('password') || !$request->get('password')) {
            $message = new ApiMessages('Password is required');
            return response()->json($message->getMessage(), 404);
        }

        Validator::make($data, [
            'phone'           => 'required',
            'mobile_phone'    => 'required',
        ]);

        try {
            $data['password'] = bcrypt($data['password']);
            $newUser = $this->users->create($data);

            $newUser->profile()->create([
                'phone'           => $data['phone'],
                'mobile_phone'    => $data['mobile_phone']
            ]);

            return response()->json([
                "message" => "User created",
                "data" => $newUser
            ], 200);
        } catch (\exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        try {
            $user = $this->users->with('profile')->findOrFail($id);
            $user->profile->social_networks = unserialize($user->profile->social_networks);
            return response()->json([
                "data" => $user
            ], 200);
        } catch (\exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $data = $request->all();
        $profile = $data['profile'];
        $profile['social_networks'] = serialize($profile['social_networks']);

        if($request->has('password') && $request->get('password')) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        try {
            $user = $this->users->findOrFail($id);
            $user->update($data);
            $user->profile()->update($profile);

            return response()->json([
                "message"=> "User updated",
                "data" => $user
            ], 200);
        } catch (\exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        try {
            $user = $this->users->findOrFail($id);
            $user->delete();

            return response()->json([
                "message"=>"User deleted"
            ], 200);
        } catch (\exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
