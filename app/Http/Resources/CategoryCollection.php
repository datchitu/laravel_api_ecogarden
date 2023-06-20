<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Log;

class CategoryCollection extends ResourceCollection
{
    public $collects = Category::class;
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'categories' => $this->mapCollection(),
            'meta'       => [
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
        $categories = $this->collection;
        $data = [];
        foreach ($categories as $item) {
            $item['avatar'] = pare_url_file($item['avatar']);
            $data[] = $item;
        }
        return $data;
    }
}
