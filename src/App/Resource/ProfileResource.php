<?php

namespace Saberyp\Cms\App\Resource;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends  JsonResource
{
    public function toArray($request)
    {
        return [
            'users'=>new UserResource($this->user),
            'address'=>$this->address,
            'mobile'=>$this->mobile,
            'old'=>$this->old,
        ];
    }
}
