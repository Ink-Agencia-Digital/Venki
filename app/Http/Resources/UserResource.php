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
            "premium" => isset($this->premium) ? $this->premium:null,
            "phone" => isset($this->phone) ? $this->phone : null,
            "photo" => isset($this->photo) ? $this->photo : null,
            "avatar" => isset($this->avatar) ? $this->avatar : null,
            "status" => isset($this->status) ? $this->status : null,
            "roles" => RoleResource::collection($this->whenLoaded('roles')),
            "sex" => isset($this->gender) ? $this->gender:null,
            "placeOfBirth"=>isset($this->placeOfBirth)?$this->placeOfBirth:null,
            "height"=>isset($this->height)?$this->height:null,
            "weight"=>isset($this->weight)?$this->weight:null,
            "dominantFoot"=>isset($this->dominantFoot)?$this->dominantFoot:null,
            "dominantHand"=>isset($this->dominantHand)?$this->dominantHand:null,
            "graduationYear"=>isset($this->graduationYear)?$this->graduationYear:null,
            "highSchoolAverage"=>isset($this->highSchoolAverage)?$this->highSchoolAverage:null,
            "gpa"=>isset($this->gpa)?$this->gpa:null,
            "sat"=>isset($this->sat)?$this->sat:null,
            "toef"=>isset($this->toef)?$this->toef:null,
            "mainSport"=>isset($this->mainSport)?$this->mainSport:null,
            "playingPosition"=>isset($this->playingPosition)?$this->playingPosition:null,
            "events"=>isset($this->events)?$this->events:null,
            "time"=>isset($this->time)?$this->time:null,
            "records"=>isset($this->records)?$this->records:null,
            "route"=>isset($this->route)?$this->route:null,
            "rankings"=>isset($this->rankings)?$this->rankings:null,
            "recognitions"=>isset($this->recognitions)?$this->recognitions:null,
            "press"=>isset($this->press)?$this->press:null,
            "differences"=>isset($this->differences)?$this->differences:null,
            "competencies"=>isset($this->competencies)?$this->competencies:null,
            "goals"=>isset($this->goals)?$this->goals:null
        ];
    }
}
