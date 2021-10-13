<?php

namespace Saberyp\Cms\App\Http;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Saberyp\Cms\App\Models\Profile;

class UserController extends Controller
{
    public function register(Request $request)
    {

        $validate=$request->validate([
            'name'=>['required','string','unique:users,name'],
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6'
        ]);

        $data=[
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'password'=>bcrypt($request->input('password')),
            'api_token'=>Str::random(100)
        ];
        $user=User::create($data);
        Profile::create([
            'user_id'=>$user->id
        ]);
        return response()->json([
            'status'=>'ok',
            'data'=>new UserResource($user)
        ],201);
    }

    public function login(Request $request)
    {
        $validData=$this->validate($request,[
            'email' => 'required|string|',
            'password' => 'required|string|min:6|',
        ]);
        if (! auth()->attempt($validData)){
            return response()->json([
                'status'=>'error',
                'data'=>'اطلاعات صحیح نیست'
            ],403);
        }
        auth()->user()->update([
            'api_token'=>Str::random(100)
        ]);

        return response()->json([
            'status'=>'ok',
            'data'=>new UserResource(auth()->user())
        ]);
    }

    public function logout()
    {
        $user=auth()->user();
        $user->update([
            'api_token'=>null
        ]);
    }

    public function index()
    {
        $user=User::query()->paginate(\request('limit'));
        return response()->json([
            'status'=>'ok',
            'data'=>UserResource::collection($user)
        ]);
    }

    public function store(Request $request)
    {
        $validate=$request->validate([
            'name'=>['required','string','unique:users,name'],
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6'
        ]);
        $data=[
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'password'=>bcrypt($request->input('password')),
            'api_token'=>Str::random(100)
        ];
        $user=User::create($data);
        return response()->json([
            'status'=>'ok',
            'data'=>new UserResource($user)
        ]);

    }

    public function show($id)
    {
        $user=User::query()->where('id',$id)->first();
        return response()->json([
            'status'=>'ok',
            'data'=>new UserResource($user)
        ]);
    }

    public function edit($id)
    {
        $user=User::query()->where('id',$id)->first();
        return response()->json([
            'status'=>'ok',
            'data'=>new UserResource($user)
        ]);
    }

    public function update(Request $request,$id)
    {
        $user=User::query()->where('id',$id)->first();
        $validate=$request->validate([
            'name'=>['required','string',Rule::unique('users','name')->ignore($id)],
            'email'=>['required','email',Rule::unique('users','email')->ignore($id)],
            'password'=>'required|min:6'
        ]);
        $data=[
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'password'=>bcrypt($request->input('password')),
        ];
        $user->update($data);

    }
    public function delete($id)
    {
        $user=User::query()->where('id',$id)->first();
        $user->delete();
    }
}
