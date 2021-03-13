<?php

namespace App\Services\Authentication\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthenticationUserResource extends JsonResource
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
            'token' => $this->resource
        ];
    }
}
