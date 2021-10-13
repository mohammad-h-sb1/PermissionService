<?php

namespace Saberyp\Cms\App\Resource;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'users'=>UserResource::collection($this->users),
            'Roles'=>RoleResource::collection($this->roles),
            'name'=>$this->name,
            'email'=>$this->email
        ];
    }
}
