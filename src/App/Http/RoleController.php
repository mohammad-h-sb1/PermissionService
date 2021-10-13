<?php

namespace Saberyp\Cms\App\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Saberyp\Cms\App\Models\Role;
use Saberyp\Cms\App\Resource\RoleResource;

class RoleController extends Controller
{
    public function index()
    {
        $role=Role::query()->paginate(\request('limit'));
        return response()->json([
            'status'=>'ok',
            'data'=>RoleResource::collection($role)
        ]);
    }

    public function store(Request $request)
    {
        $validate=$request->validate([
            'name'=>'required|unique:Roles|max:255|string',
            'label'=>'string|max:255',
            'user'=>'array|exists:users,id|',
            'permissions'=>'array|exists:permissions,id|'
        ]);
        $data=[
            'name'=>$validate['name'],
            'label'=>$request->label,
        ];
        $role=Role::create($data);
        $role->Users()->sync($request->input('user'));
        $role->permissions()->sync($request->input('permissions'));
        return response()->json([
            'status'=>'ok',
            'data'=>new RoleResource($role)
        ]);
    }

    public function show($id)
    {
        $role=Role::query()->where('id',$id)->first();
        return response()->json([
            'status'=>'ok',
            'data'=>new RoleResource($role)
        ]);
    }

    public function edit($id)
    {
        $role=Role::query()->where('id',$id)->first();
        return response()->json([
            'status'=>'ok',
            'data'=>new RoleResource($role)
        ]);
    }

    public function update(Request $request,$id)
    {
        $role=Role::query()->where('id',$id)->first();
        $validate=$request->validate([
            'name'=>['required',Rule::unique('roles','name')->ignore($id),'max:255','string'],
            'label'=>'string|max:255',
            'user'=>'array|exists:users,id|',
            'permissions'=>'array|exists:permissions,id|'
        ]);
        $data=[
            'name'=>$validate['name'],
            'label'=>$request->label,
        ];
        $role->update($data);
        $role->Users()->sync($request->input('user'));
        $role->permissions()->sync($request->input('permissions'));
        return response()->json([
            'status'=>'ok',
            'data'=>new RoleResource($role)
        ]);
    }

    public function delete($id)
    {
        Role::query()->where('id',$id)->delete();
    }
}
