<?php

namespace Saberyp\Cms\App\Http;

use App\Http\Controllers\Controller;
use Doctrine\Inflector\Rules\French\Rules;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Saberyp\Cms\App\Models\Permission;
use Saberyp\Cms\App\Resource\PermissionResource;

class PermissionController extends Controller
{
    public function index()
    {
        $permission=Permission::query()->paginate(\request('limit'));
        return response()->json([
            'status'=>'ok',
            'data'=>PermissionResource::collection($permission)
        ]);
    }

    public function store(Request $request)
    {
        $validate=$request->validate([
            'name'=>'required|unique:permissions|max:255|string',
            'label'=>'string|max:255',
            'user'=>'array|exists:users,id|',
            'role'=>'array|exists:roles,id|'
        ]);
        $permission=Permission::create([
            'name'=>$validate['name'],
            'label'=>$request->label,
        ]);
        $permission->users()->sync($request->input('user'));
        $permission->roles()->sync($request->input('role'));
        return response()->json([
            'status'=>'ok',
            'data'=>new PermissionResource($permission)
        ]);
    }

    public function show($id)
    {
        $permission=Permission::query()->where('id',$id)->first();
        return response()->json([
            'status'=>'ok',
            'data'=>new PermissionResource($permission)
        ]);
    }

    public function edit($id)
    {
        $permission=Permission::query()->where('id',$id)->first();

        return response()->json([
            'status'=>'ok',
            'data'=>new PermissionResource($permission)
        ]);
    }

    public function update(Request $request,$id)
    {
        $permission=Permission::query()->where('id',$id)->first();
        $validate=$request->validate([
            'name'=>['required',Rule::unique('permissions','name')->ignore($id),'max:255','string'],
            'label'=>'string|max:255',
            'user_id'=>'array|exists:users,id|',
            'role_id'=>'array|exists:roles,id|'
        ]);
        $data=[
            'name'=>$request->name,
            'label'=>$request->label
        ];
        $permission->update($data);
        $permission->users()->sync($request->input('user_id'));
        $permission->roles()->sync($request->input('role_id'));
    }

    public function delete($id)
    {
        $permission=Permission::query()->where('id',$id)->first();
        $permission->delete();

    }
}
