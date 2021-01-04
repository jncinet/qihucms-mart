<?php

namespace Qihucms\Mart\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class Mart extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->user_id,
            'name' => $this->name,
            'logo' => empty($this->logo) ? null : Storage::url($this->logo),
            'banner' => empty($this->banner) ? null : Storage::url($this->banner),
            'return_name' => $this->return_name,
            'return_phone' => $this->return_phone,
            'return_address' => $this->return_address,
            'about' => $this->about,
            'exp' => $this->exp,
            'status' => $this->status,
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
        ];
    }
}
