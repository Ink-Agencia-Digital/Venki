<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => isset($this->id) ? $this->id : null,
            "name" => isset($this->name) ? $this->name : null,
            "email" => isset($this->email) ? $this->email : null,
            "lastname" => isset($this->lastname) ? $this->lastname : null,
            "birthday" => isset($this->birthday) ? $this->birthday : null,
            "phone" => isset($this->phone) ? $this->phone : null,
            "photo" => isset($this->photo) ? $this->photo : null,
            "avatar" => isset($this->avatar) ? $this->avatar : null,
            "status" => isset($this->status) ? $this->status : null,
            "roles" => RoleResource::collection($this->whenLoaded('roles'))
        ];
    }
}
