<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PlanCollection extends ResourceCollection
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
                "value" => [
                    'plan_id' => $item->id,
                    'name' => $item->name,
                    'description' => $item->description,
                    'invoice_name' => $item->invoiceName,
                    'price' => $item->price,
                    'currency' => $item->currencyCode,
                    'billing_cycle' => $item->periodUnit,
                    'trial_period' => $item->trialPeriod,
                    'plan_group' => 'SC2',
                    'option_id' => ''
                ],
                "label" => $item->name
            ]);
        }

        return $itemList;
    }
}
