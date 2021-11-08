<?php


namespace Tomeet\FriendlyLink\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tomeet\FriendlyLink\ModelFilters\FriendlyLinkFilter;
use Tomeet\FriendlyLink\Models\Traits\FriendlyLinkTrait;

class FriendlyLink extends Model
{
    use HasFactory, Filterable, FriendlyLinkTrait;

    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
    ];

    public function modelFilter()
    {
        return $this->provideFilter(FriendlyLinkFilter::class);
    }

    public function group()
    {
        return $this->belongsTo(FriendlyLinkGroup::class);
    }
}
