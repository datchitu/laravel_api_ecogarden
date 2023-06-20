<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class OrderResource extends JsonResource
{
    public $collects = Order::class;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $order                          = [
            'id'               => $this->id,
            'user_id'          => $this->user_id,
            'total_money'      => $this->total_money,
            'discount'         => $this->discount,
            'receiver_name'    => $this->receiver_name,
            'receiver_email'   => $this->receiver_email,
            'receiver_phone'   => $this->receiver_phone,
            'receiver_address' => $this->receiver_address,
            'status'           => $this->status,
            'shipping_status'  => $this->shipping_status,
            'transactions'     => $this->transactions,
            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at,
        ];
        $order['status_order']          = $this->getStatus($this->status);
        $order['shipping_status_order'] = $this->getStatusShippingConfig($this->shipping_status);

        return $order;
    }
}
