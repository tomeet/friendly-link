<?php


namespace Tomeet\FriendlyLink\Http\Controllers\Admin;


use Jiannei\Response\Laravel\Support\Facades\Response;
use Tomeet\FriendlyLink\Http\Controllers\Controller;
use Tomeet\FriendlyLink\Models\FriendlyLinkGroup;
use Tomeet\FriendlyLink\Http\Requests\Admin\FriendlyLinkGroupRequest;
use Tomeet\FriendlyLink\Http\Resources\Admin\FriendlyLinkGroupResource;
use Illuminate\Http\Request;

class FriendlyLinkGroupController extends Controller
{
    /**
     * 获取友情链接分组列表
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $groups = FriendlyLinkGroup::filter($request->all())->orderBy('sort', 'asc')->paginate();
        $groups->load('links');
        return Response::success(FriendlyLinkGroupResource::collection($groups));
    }


    /**
     * 创建友情链接分组
     *
     * @param FriendlyLinkGroupRequest $request
     * @return mixed
     */
    public function store(FriendlyLinkGroupRequest $request)
    {
        $group = new FriendlyLinkGroup();
        $group->fill($request->all());
        $group->save();
    }


    /**
     * 获取友情链接分组信息
     *
     * @param FriendlyLinkGroup $group
     * @return mixed
     */
    public function show($id)
    {
        $group = FriendlyLinkGroup::findOrFail($id);
        return Response::success(new FriendlyLinkGroupResource($group));
    }


    /**
     * 更新友情链接分组信息
     *
     * @param FriendlyLinkGroupRequest $request
     * @param FriendlyLinkGroup $group
     */
    public function update(FriendlyLinkGroupRequest $request, $id)
    {
        $group = FriendlyLinkGroup::findOrFail($id);
        $group->fill($request->all());
        $group->save();
    }


    /**
     * 删除友情链接分组
     *
     * @param FriendlyLinkGroup $group
     */
    public function destroy($id)
    {
        $group = FriendlyLinkGroup::findOrFail($id);
        $group->delete();
    }


    /**
     * 批量删除友情链接分组
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        $groups = FriendlyLinkGroup::filter($request->all())->get();
        $groups->map(function ($group) {
            $group->delete();
        });
    }


    /**
     * 上移，下移友情链接分组
     *
     * @param Request $request
     * @param $id
     */
    public function setShowOrder(Request $request, $id)
    {
        $direction = $request->direction ?? '';
        if ($direction == '' || !in_array($direction, ['up', 'down'])) {
            Response::fail('参数错误', 422);
        }

        $group = FriendlyLinkGroup::findOrFail($id);
        FriendlyLinkGroup::handleMove($group, $direction);
    }
}
