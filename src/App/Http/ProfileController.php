<?php

namespace Saberyp\Cms\App\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Saberyp\Cms\App\Models\Profile;
use Saberyp\Cms\App\Resource\ProfileResource;

class ProfileController extends Controller
{
    public function show()
    {
        $profile=Profile::query()->where('user_id',auth()->user()->id)->first();
        return response()->json([
            'status'=>'ok',
            'data'=>new ProfileResource($profile)
        ]);
    }

    public function edit()
    {
        $profile=Profile::query()->where('user_id',auth()->user()->id)->first();
        return response()->json([
            'status'=>'ok',
            'data'=>new ProfileResource($profile)
        ]);
    }

    public function update(Request $request)
    {
        $profile=Profile::query()->where('user_id',auth()->user()->id)->first();
        $validate=$request->validate([
            'mobile' => ['regex:/^(?:0|98|\+98|\+980|0098|098|00980)?(9\d{9})$/',Rule::unique('profiles','mobile')->ignore($profile->id)],
            'address'=>'string|max:255',
            'old'=>'string|max:150',
        ]);
        $data=[
            'mobile'=>$request->input('mobile'),
            'address'=>$request->input('address'),
            'old'=>$request->input('old')
        ];
        $profile->update($data);
    }
}
