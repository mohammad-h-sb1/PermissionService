<?php

namespace Saberyp\Cms\App\Resource\Admin;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Saberyp\Cms\App\Resource\PermissionResource;
use Saberyp\Cms\App\Resource\RoleResource;

class ProfileResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'users'=>new UserResource($this->user),
            'Roles'=>RoleResource::collection($this->user->roles),
            'Permission'=>PermissionResource::collection($this->user->permissions),
            'address'=>$this->address,
            'mobile'=>$this->mobile,
            'old'=>$this->old,
        ];
    }
}
