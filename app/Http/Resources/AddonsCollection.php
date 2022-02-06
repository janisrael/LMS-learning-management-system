<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AddonsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $itemList = [];

        foreach ($this->collection as $item) {
            array_push($itemList, [         
                'id' => $item->id,
                'name' => $item->name,
                'description' => $item->description,
                'invoice_name' => $item->invoiceName,
                'price' => $item->price,
                'currency' => $item->currencyCode,
                'charge_type' => $item->chargeType,
                'is_added' => false
            ]);
        }

        return $itemList;
    }
}
