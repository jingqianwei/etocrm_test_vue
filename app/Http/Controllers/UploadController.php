<?php

namespace App\Http\Controllers;

use App\utils\FileManager\BaseManager;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * @var BaseManager
     */
    protected $manager;

    /**
     * UploadController constructor.
     * @param BaseManager $manager
     */
    public function __construct(BaseManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * 上传图片
     *
     * @param Request $request
     * @return mixed
     */
    public function image(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image'
        ]);

        $path = date('Y') . date('m') . '/' . date('d');

        $resource = $this->manager->store($request->file('image'), $path);

        // 对文章封面进行裁剪
        if ($request->input('type') == 'article') {
            $this->reduceArticleSize(public_path($resource['relative_url']), $resource['filename']);
        }

        return $this->response($resource);
    }

    /**
     * 对文章封面图片进行裁剪 PC 和小程序中显示
     *
     * @param string $file_path 文件绝对路径
     * @param string $filename 文件名
     */
    public function reduceArticleSize($file_path, $filename)
    {
        // 先实例化，传参是文件的磁盘物理路径
        $image = Image::make($file_path);

        // 进行大小调整的操作 PC端显示
        $image->resize(568, 200)->save($file_path);

        // 进行大小调整的操作 小程序端显示
        $image->resize(372, 110)->save($file_path . '_372x110px' . strrchr($filename, '.'));

        // 进行大小调整的操作 小程序分享显示
        $image->resize(500, 400)->save($file_path . '_500x400px' . strrchr($filename, '.'));
    }
}
