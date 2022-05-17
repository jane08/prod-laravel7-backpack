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
            'id' => $this->id,
          //  'name' => $this->name,
            'email' => $this->email,
            'api_token' => $this->api_token,
            'referral_link' => 'referer_id='.$this->id,
        ];
    }
}
