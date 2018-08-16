<?php
/**
 * Created by PhpStorm.
 * User: chinwe.jing
 * Date: 2018/8/16
 * Time: 10:52
 */

namespace App\utils\FileManager;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class BaseManager
{
    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem|\Illuminate\Filesystem\FilesystemAdapter
     */
    protected $disk;

    /**
     * BaseManager constructor.
     */
    public function __construct()
    {
        $this->disk = Storage::disk(config('filesystems.default'));
    }

    /**
     * @Describe: 获取所有文件
     * @Author: chinwe.jing
     * @Data: 2018/8/16 11:01
     * @param $directory
     * @return array
     */
    public function getAllFiles($directory)
    {
        return $this->disk->allFiles($directory);
    }


    /**
     * @Describe: 删除文件
     * @Author: chinwe.jing
     * @Data: 2018/8/16 11:03
     * @param $path
     * @return bool
     */
    public function delete($path)
    {
        return $this->disk->delete($path);
    }

    /**
     * @Describe: 上传文件
     * @Author: chinwe.jing
     * @Data: 2018/8/16 11:15
     * @param UploadedFile $file
     * @param null $dir
     * @return array
     */
    public function store(UploadedFile $file, $dir = null)
    {
        $hashName = $file->hashName();

        $mine = $file->getMimeType();

        $realName = $this->disk->putFileAs($dir, $file, $hashName);

        return [
            'success' => true,
            'filename' => $hashName,
            'original_name' => $file->getClientOriginalName(),
            'mine' => $mine,
            'size' => $file->getSize(),
            'relative_url' => '/storage/' . $realName,
            'full_relative_url' => url('/storage/' . $realName),
        ];
    }
}