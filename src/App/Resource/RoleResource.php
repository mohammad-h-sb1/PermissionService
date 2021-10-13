<?php

namespace Saberyp\Cms\App\Resource;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'users'=>UserResource::collection($this->users),
            'name'=>$this->name,
            'email'=>$this->email
        ];
    }
}
