<?php


namespace Tomeet\FriendlyLink\Models\Traits;


use Illuminate\Support\Facades\Storage;
use Tomeet\FriendlyLink\Models\FriendlyLink;
use Exception;

trait FriendlyLinkTrait
{

    public static function bootFriendlyLinkTrait()
    {
        static::created(function ($model) {
            $model->sort = $model->id;
            $model->save();
        });

        static::deleting(function ($model) {
            //TODO:: 同时删除已上传的LOGO图片
        });
    }


    /**
     * 处理友情链接Logo上传
     *
     * @param $request
     * @return array
     * @throws Exception
     */
    public static function handleUploadLogo($request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            if ($file->isValid()) {
                try {
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $mineType = $file->getClientMimeType();
                    $filesize = $file->getSize();
                    $filepath = Storage::put('friendlylink/logo/', $file);

                    return [
                        'originalName' => $originalName,
                        'filename' => basename($filepath),
                        'filepath' => $filepath,
                        'url' => Storage::url($filepath),
                        'ext' => $extension,
                        'size' => $filesize,
                        'mine_type' => $mineType,
                    ];
                } catch (Exception $exception) {
                    throw $exception;
                }
            }
        }
    }


    /**
     * 删除已上传的友情链接Logo
     *
     * @param $file
     */
    public static function handleDeleteLinkLogo($file)
    {
        Storage::delete($file);
    }


    /**
     * 设置友情链接顺序（上移，下移）
     *
     * @param $request
     * @param $groupId
     */
    public static function handleMove($link, $direction = 'up')
    {
        $sort = $link->sort;
        if ($direction == 'up') {
            $near = FriendlyLink::where('sort', '<', $sort)->orderBy('sort', 'desc')->first();
        } else {
            $near = FriendlyLink::where('sort', '>', $sort)->orderBy('sort', 'asc')->first();
        }
        if ($near) {
            // 更新排序
            $link->sort = $near->sort;
            $link->save();
            $near->sort = $sort;
            $near->save();
        }
    }
}
