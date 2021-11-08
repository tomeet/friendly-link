<?php


namespace Tomeet\FriendlyLink\Models\Traits;


use Tomeet\FriendlyLink\Models\FriendlyLinkGroup;
use Exception;

trait FriendlyLinkGroupTrait
{

    public static function bootFriendlyLinkGroupTrait()
    {
        static::created(function ($model) {
            $model->sort = $model->id;
            $model->save();
        });

        static::deleting(function ($model) {
            $model->links()->delete();
        });
    }


    /**
     * 设置友情链接分组顺序（上移，下移）
     *
     * @param $request
     * @param $groupId
     */
    public static function handleMove($group, $direction = 'up')
    {
        $sort = $group->sort;
        if ($direction == 'up') {
            $near = FriendlyLinkGroup::where('sort', '<', $sort)->orderBy('sort', 'desc')->first();
        } else {
            $near = FriendlyLinkGroup::where('sort', '>', $sort)->orderBy('sort', 'asc')->first();
        }
        if ($near) {
            // 更新排序
            $group->sort = $near->sort;
            $group->save();
            $near->sort = $sort;
            $near->save();
        }
    }
}
