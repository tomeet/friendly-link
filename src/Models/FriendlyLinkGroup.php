<?php


namespace Tomeet\FriendlyLink\Models;


use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tomeet\FriendlyLink\ModelFilters\FriendlyLinkGroupFilter;
use Tomeet\FriendlyLink\Models\Traits\FriendlyLinkGroupTrait;

class FriendlyLinkGroup extends Model
{
    use HasFactory, Filterable, FriendlyLinkGroupTrait;

    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
    ];

    public function modelFilter()
    {
        return $this->provideFilter(FriendlyLinkGroupFilter::class);
    }

    public function links()
    {
        return $this->hasMany(FriendlyLink::class, 'group_id');
    }
}
