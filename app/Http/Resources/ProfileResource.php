<?php

namespace App\Http\Resources;

use App\Http\Services\CityService;
use App\Http\Services\CountryService;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'first_name' => ($this->first_name),
            'last_name' => ($this->last_name),
            'telegram' => ($this->telegram),
            'instagram' => ($this->instagram),
            'country' => CountryService::getOneByCountryName($this->country)->id ?? ($this->country),
            'city' =>  ($this->city_text),
            'ip' => ($this->ip),
            'email' => ($this->user->email),
            'api_token' => ($this->user->api_token),
            'referral_link' => 'referer_id='.$this->user_id,
            'user_id' => ($this->user_id),
            'avatar' => ($this->avatar),
        ];
    }
}
