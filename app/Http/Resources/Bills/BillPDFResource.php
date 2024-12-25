<?php

namespace App\Http\Resources\Bills;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillPDFResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' =>  $this->id,
            'type' => $this->type,
            'formatted_text_url' => $this->formatted_text_url,
            'pdf_url' => $this->pdf_url,
        ];
    }
}
