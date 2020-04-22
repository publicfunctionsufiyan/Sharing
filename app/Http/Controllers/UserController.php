<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Media;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function register(Request $request)
     {

        $validator = Validator::make($request->all(), ['fname' => 'required', 'email' => 'required|email', 'password' => 'required|confirmed']);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('Laravel Password Grant Client')->accessToken;
        $success['user'] = $user;
        
        return response()->json(['success' => $success], 200);
     }

public function profilePicture(Request $request, $id)
{
              $user = User::findOrFail($id);
              $input = $request->all();
              $user->addMedia($input['image'])->toMediaCollection('user-images');
              return response()->json(['success' => true], 200);

}


     public function login()
     {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('Laravel Password Grant Client')->accessToken;
            unset($user->password);
            $success['user'] = $user;
            return response()->json(['success' => $success], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }


     }

     public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showAllUsers()
    {
        return User::all();
    }

    public function showUserById($id)
    {
        $user = User::findOrFail($id);
        $user->getMedia('user-images');
        return $user;



    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $input = $request->all();
        $user->update($request->all());


        if($request->hasFile('image'))
        {
          $user->clearMediaCollection('user-images');
          $user->addMedia($input['image'])->toMediaCollection('user-images');

          // Media::where('model_type', 'App\User')->where('model_id', $id)->delete();



        }



        return 'User updated successfully';
    }





    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
