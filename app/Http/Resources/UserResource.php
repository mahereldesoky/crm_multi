<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Permission\Models\Permission;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "token" => $this->createToken('Token')->plainTextToken,
            "role" => $this->roles,
            "permissions" => $this->Permissions,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}


// 