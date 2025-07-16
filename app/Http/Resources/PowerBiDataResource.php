<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PowerBiDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'users' => UserResource::collection($this->resource['users']),
            'organizations' => OrganizationResource::collection($this->resource['organizations']),
            'surveys' => $this->resource['surveys'],
            'meta' => [
                'generated_at' => now()->format('Y-m-d H:i:s'),
                'total_users' => $this->resource['users']->count(),
                'total_organizations' => $this->resource['organizations']->count(),
            ]
        ];
    }
}
