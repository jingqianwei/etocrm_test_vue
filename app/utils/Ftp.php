<?php
/**
 * Created by PhpStorm.
 * User: chinwe.jing
 * Date: 2018/8/16
 * Time: 13:48
 */

namespace App\utils;

/********************************************
 * MODULE:FTP类
 * 参考网址：https://blog.csdn.net/u010231111/article/details/74932199
 *******************************************/
class Ftp
{
    public $off;             // 返回操作状态(成功/失败)
    public $conn_id;         // FTP连接

    /**
     * 方法：FTP连接
     * @param $FTP_HOST -- FTP主机
     * @param $FTP_PORT -- 端口
     * @param $FTP_USER -- 用户名
     * @param $FTP_PASS -- 密码
     */
    public function __construct($FTP_HOST, $FTP_PORT, $FTP_USER, $FTP_PASS)
    {
        $this->conn_id = @ftp_connect($FTP_HOST, $FTP_PORT) or die("FTP服务器连接失败");
        @ftp_login($this->conn_id, $FTP_USER, $FTP_PASS) or die("FTP服务器登陆失败");
        @ftp_pasv($this->conn_id, 1); // 打开被动模拟
    }

    /**
     * 方法：上传文件
     * @param $path -- 本地路径
     * @param $newpath -- 上传路径
     * @param bool $type
     */
    public function upFile($path, $newpath, $type = true)
    {
        if ($type) $this->mkDirs($newpath);
        $this->off = @ftp_put($this->conn_id, $newpath, $path, FTP_BINARY);
        if (!$this->off) echo "文件上传失败,请检查权限及路径是否正确！";
    }

    /**
     * 方法：移动文件
     * @param $path -- 原路径
     * @param $newpath -- 新路径
     * @param bool $type
     */
    public function moveFile($path, $newpath, $type = true)
    {
        if ($type) $this->mkDirs($newpath);
        $this->off = @ftp_rename($this->conn_id, $path, $newpath);
        if (!$this->off) echo "文件移动失败,请检查权限及原路径是否正确！";
    }

    /**
     * 方法：复制文件
     * 说明：由于FTP无复制命令,本方法变通操作为：下载后再上传到新的路径
     * @param $path -- 原路径
     * @param $newpath -- 新路径
     * @param bool $type
     */
    public function copyFile($path, $newpath, $type = true)
    {
        $downpath = "c:/tmp.dat";
        $this->off = @ftp_get($this->conn_id, $downpath, $path, FTP_BINARY);// 下载
        if (!$this->off) echo "文件复制失败,请检查权限及原路径是否正确！";
        $this->upFile($downpath, $newpath, $type);
    }

    /**
     * 方法：删除文件
     * @param $path -- 路径
     */
    public function delFile($path)
    {
        $this->off = @ftp_delete($this->conn_id, $path);
        if (!$this->off) echo "文件删除失败,请检查权限及路径是否正确！";
    }

    /**
     * 方法：生成目录
     * @param $path -- 路径
     */
    public function mkDirs($path)
    {
        $path_arr = explode('/', $path);       // 取目录数组
        array_pop($path_arr);                    // 弹出文件名
        $path_div = count($path_arr);                   // 取层数

        foreach ($path_arr as $val)                     // 创建目录
        {
            if (@ftp_chdir($this->conn_id, $val) == FALSE) {
                $tmp = @ftp_mkdir($this->conn_id, $val);
                if ($tmp == FALSE) {
                    echo "目录创建失败,请检查权限及路径是否正确！";
                    exit;
                }
                @ftp_chdir($this->conn_id, $val);
            }
        }

        for ($i = 1; $i <= $path_div; $i++)          // 回退到根
        {
            @ftp_cdup($this->conn_id);
        }
    }

    /**
     * 方法：关闭FTP连接
     */
    public function close()
    {
        @ftp_close($this->conn_id);
    }
}