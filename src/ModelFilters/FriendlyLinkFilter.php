<?php


namespace Tomeet\FriendlyLink\ModelFilters;


use EloquentFilter\ModelFilter;

class FriendlyLinkFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];


    /**
     * 关键词查询
     *
     * @param $keywords
     * @return FriendlyLinkFilter
     */
    public function keywords($keywords)
    {
        return $this->where('name', 'like', '%' . $keywords . '%');
    }


    /**
     * 文章所属分类
     *
     * @param $id
     * @return ArticleFilter
     */
    public function group($id)
    {
        return $this->where('group_id', $id);
    }
}
