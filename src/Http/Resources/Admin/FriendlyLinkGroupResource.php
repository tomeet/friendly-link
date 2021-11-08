<?php


namespace Tomeet\FriendlyLink\Http\Resources\Admin;


use Illuminate\Http\Resources\Json\JsonResource;

class FriendlyLinkGroupResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sort' => $this->sort,
            'link_count' => $this->whenLoaded('links', $this->getLinkCount()),
            'created_at' => $this->created_at->format('Y-m-d H:i'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i'),
        ];
    }


    private function getLinkCount()
    {
        return $this->links->count();
    }
}
