<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Log;

class OrderCollection extends ResourceCollection
{
    public $collects = Order::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'orders' => $this->mapCollection(),
            'meta'   => [
                'total'        => $this->total(),
                'count'        => $this->count(),
                'per_page'     => $this->perPage(),
                'current_page' => $this->currentPage(),
                'total_pages'  => $this->lastPage()
            ],
        ];
    }


    public function mapCollection()
    {
        $transactions = $this->collection;
        $data         = [];
        foreach ($transactions as $transaction) {
            $item                          = $transaction;
            $item['status_order']          = $transaction->getStatus($transaction->status);
            $item['shipping_status_order'] = $transaction->getStatusShippingConfig($transaction->shipping_status);
            $data[]                        = $item;
        }
        return $data;
    }
}
