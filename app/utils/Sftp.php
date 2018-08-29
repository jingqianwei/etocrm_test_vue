<?php
/**
 * Created by PhpStorm.
 * User: chinwe.jing
 * Date: 2018/8/16
 * Time: 13:44
 */

namespace App\utils;

/********************************************
 * MODULE:SFTP类
 * 参考网址：https://blog.csdn.net/u010231111/article/details/74932199
 *******************************************/
class Sftp
{
    // 初始配置为NULL
    private $config = NULL;
    // 连接为NULL
    private $conn = NULL;
    // 是否使用秘钥登陆
    private $use_pubkey_file = false;

    // 初始化
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @Describe: 连接ssh ,连接有两种方式(1) 使用密码 (2) 使用秘钥
     * @Author: chinwe.jing
     * @Data: 2018/8/29 14:10
     * @return bool
     */
    public function connect()
    {
        $methods = $this->use_pubkey_file ? ['hostkey' => 'ssh-rsa'] : [];
        $this->conn = ssh2_connect($this->config['host'], $this->config['port'], $methods);
        //(1) 使用秘钥的时候
        if ($this->use_pubkey_file) {
            // 用户认证协议
            $rc = ssh2_auth_pubkey_file($this->conn, $this->config['user'], $this->config['pubkey_file'], $this->config['privkey_file'], $this->config['passphrase']);
            //(2) 使用登陆用户名字和登陆密码
        } else {
            $rc = ssh2_auth_password($this->conn, $this->config['user'], $this->config['passwd']);
        }

        return $rc;
    }

    /**
     * @Describe: 传输数据 传输层协议,获得数据
     * @Author: chinwe.jing
     * @Data: 2018/8/29 14:06
     * @param string $remote sftp服务器文件地址
     * @param string $local 要下载的本地文件地址
     * @return bool
     */
    public function download($remote, $local)
    {
        return ssh2_scp_recv($this->conn, $remote, $local);
    }

    /**
     * @Describe:传输数据 传输层协议,写入sftp服务器数据
     * @Author: chinwe.jing
     * @Data: 2018/8/29 14:03
     * @param string $local 要上传的本地文件地址
     * @param string $remote sftp服务器文件地址(存在就写入内容，不存在就创建文件再写入内容)
     * @param int $file_mode 创建文件权限
     * @return bool
     */
    public function upload($local, $remote, $file_mode = 0664)
    {
        return ssh2_scp_send($this->conn, $local, $remote, $file_mode);
    }

    /**
     * @Describe: 删除sftp服务器上文件或者文件夹
     * @Author: chinwe.jing
     * @Data: 2018/8/29 14:06
     * @param string $remote sftp服务器文件地址或者目录地址
     * @return bool
     */
    public function remove($remote)
    {
        $sftp = ssh2_sftp($this->conn);
        if (is_dir("ssh2.sftp://{$sftp}/{$remote}")) {
            // ssh 删除文件夹
            $rc = ssh2_sftp_rmdir($sftp, $remote);
        } else {
            // 删除文件
            $rc = ssh2_sftp_unlink($sftp, $remote);
        }

        return $rc;
    }

    /**
     * @Describe: 检测sftp服务器上目录是否存在
     * @Author: chinwe.jing
     * @Data: 2018/8/29 14:08
     * @param string $dir 目录地址，这里的目录是以根目录开始算的
     * @return bool
     */
    public function ssh2_dir_exits($dir)
    {
        $sftp = ssh2_sftp($this->conn);
        if (is_dir("ssh2.sftp://{$sftp}/{$dir}")) {
            return true;
        }

        return false;
    }

    /**
     * @Describe: sftp服务器上创建目录
     * @Author: chinwe.jing
     * @Data: 2018/8/29 14:09
     * @param string $dir 目录地址
     * @param int $dir_mode 目录权限
     */
    public function sftp_mkDir($dir, $dir_mode = 0664) {
        $sftp = ssh2_sftp($this->conn);
        ssh2_sftp_mkdir($sftp, $dir, $dir_mode);
    }

    /**
     * @Describe: 关闭sftp连接
     * @Author: chinwe.jing
     * @Data: 2018/8/29 14:40
     * @return bool
     */
    public function disconnect()
    {
        // if disconnect function is available call it..
        if (function_exists( 'ssh2_disconnect')) {
            ssh2_disconnect($this->conn);
        } else { // if no disconnect func is available, close conn, unset var
            @fclose($this->conn);
            $this->conn = NULL;
        }

        return true;
    }
}