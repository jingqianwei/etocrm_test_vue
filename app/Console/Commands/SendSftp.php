<?php

namespace App\Console\Commands;

use App\utils\Sftp;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendSftp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:sftp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每天五点定时将麦当劳的数据通过sftp上传到服务器';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);

        $tableName = Carbon::now()->format('Ymd');
        // $tableName = '20171220';
        $beginIndex = 0;
        $pageLimit = 50000;
        $endIndex = $beginIndex + $pageLimit;

        while ($pageData = \DB::connection('hub_log')->select("SELECT * FROM `{$tableName}` WHERE Content -> '$.appid' = 'wx4ed9e1f4e0f3eeb0' AND (Content ->'$.Event' = 'user_get_card' OR Content -> '$.Event' =  'user_consume_card') AND id > {$beginIndex} and id <= {$endIndex}")) {
            foreach ($pageData as $row) {
                file_put_contents(storage_path('mcd_rawdata/'.$tableName.'.txt'), $row->Content . "\n", FILE_APPEND);
            }

            $beginIndex += $pageLimit;
            $endIndex += $pageLimit;
        }
        $this->info('文件写入完成');

        foreach (\File::files(storage_path('mcd_rawdata')) as $file) {
            // 解压
            // $command = 'tar -xzf ' . explode('.', $file)[0] . '.dat.gz ' . $file;
            // 压缩
            $command = 'cd /data/html/manage/storage/mcd_rawdata/ && tar -czf ' . basename(explode('.', $file)[0]) . '.dat.gz ' . basename($file);
            exec($command);
        }
        $this->info('文件压缩完成');

        $real_path = $tableName.'.dat.gz';
        foreach (\File::files(storage_path('mcd_rawdata')) as $files) {
            $file_path = substr($files, -15);
            if($file_path == $real_path){
                $this->getSftp($files, $tableName, $real_path);

                $files_md5 =  md5($files);
                file_put_contents(storage_path('mcd_rawdata/'.$tableName.'.MD5'), $files_md5, FILE_APPEND);
            }
        }
        $this->info('上传文件并将文件MD5');

        $file_md = $tableName.'.MD5';
        foreach (\File::files(storage_path('mcd_rawdata')) as $value) {
            $file_attr = substr($value, -12);
            if($file_attr == $file_md){
                $this->getSftp($value, $tableName, $file_md);
            }
        }
        $this->info('上传MD5文件，完成任务……');
    }

    public function getSftp($localhost_file, $tableName, $real_path)
    {
        $config = array(
            "host"=> "118.25.33.139",
            "username"=> "etocrm_user",
            "port"=> "30022",
            "password"=> "7G0SPIco5odMTu5I"
        );

        try {
            $sftp = new Sftp($config);

            $re = $sftp->ssh2_dir_exits("/upload/$tableName");
            //如果目录存在直接上传
            if($re){
                $sftp->upload($localhost_file,"/upload/$tableName/".$real_path);
            }else{
                $sftp->sftp_mkDir("/upload/$tableName");
                $sftp->upload($localhost_file,"/upload/$tableName/".$real_path);
            }

            Log::info('上传成功');
        } catch (\Exception $e) {
            Log::info('上传失败：'.$e->getMessage());
        }
    }
}
