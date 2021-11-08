<?php


namespace Tomeet\FriendlyLink\Http\Controllers\Admin;

use Jiannei\Response\Laravel\Support\Facades\Response;
use Tomeet\FriendlyLink\Http\Controllers\Controller;
use Tomeet\FriendlyLink\Models\FriendlyLink;
use Tomeet\FriendlyLink\Http\Resources\Admin\FriendlyLinkResource as LinkResource;
use Tomeet\FriendlyLink\Http\Requests\Admin\FriendlyLinkRequest;
use Illuminate\Http\Request;
use Exception;

class FriendlyLinkController extends Controller
{

    /**
     * 获取友情链接列表
     *
     * @param Request $request
     * @param $groupId
     * @return mixed
     */
    public function index(Request $request)
    {
        $links = FriendlyLink::filter($request->all())->orderBy('sort', 'asc')->paginate();
        return Response::success(LinkResource::collection($links));
    }


    /**
     * 创建新增友情链接
     *
     * @param FriendlyLinkRequest $request
     * @return mixed
     */
    public function store(FriendlyLinkRequest $request)
    {
        $link = new FriendlyLink();
        $link->fill($request->all());
        $link->save();

        return Response::created();
    }


    /**
     * 获取某条友情链接
     *
     * @param FriendlyLink $link
     * @return mixed
     */
    public function show($id)
    {
        $link = FriendlyLink::findOrFail($id);
        return Response::success(new LinkResource($link));
    }


    /**
     * 更新友情链接信息
     *
     * @param FriendlyLinkRequest $request
     * @param FriendlyLink $link
     */
    public function update(FriendlyLinkRequest $request, $id)
    {
        $link = FriendlyLink::findOrFail($id);
        $link->fill($request->all());
        $link->save();
    }


    /**
     * 删除某条友情链接
     *
     * @param FriendlyLink $link
     */
    public function destroy($id)
    {
        $link = FriendlyLink::findOrFail($id);
        $link->delete();
    }


    /**
     * 批量删除友情链接
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        $links = FriendlyLink::filter($request->all())->get();
        $links->map(function ($link) {
            $link->delete();
        });
    }


    /**
     * 友情链接上移下移
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

        $link = FriendlyLink::findOrFail($id);
        FriendlyLink::handleMove($link, $direction);
    }
}
