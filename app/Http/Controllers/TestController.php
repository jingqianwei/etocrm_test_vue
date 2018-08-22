<?php

namespace App\Http\Controllers;

use App\Services\Contracts\CustomServiceInterface;
use App\Http\Resources\UserResource;
use Cblink\ExcelZip\ExcelZip;
use Illuminate\Http\Request;
use App\Events\MyEvent;
use App\utils\Export;
use App\Models\User;

class TestController extends Controller
{
    //测试写一个新的provide，然后根据不同的条件来实例化不同的service
    public function index(CustomServiceInterface $customServiceInstance, Request $request)
    {

        $val = 1;
        $con = $val ?: 0; //php7新特性
        dd($con);
        $data = [
            [
                'create_at'=> '2018',
                'num'=>1,
            ],
            [
                'create_at'=> '2018',
                'num'=>2,
            ],
            [
                'create_at'=> '2017',
                'num'=>3,
            ],
            [
                'create_at'=> '2016',
                'num'=>4,
            ]
        ];

        $multiplied = collect($data)->groupBy('create_at')
                                    ->map(function($item){
                                        return ['total_num' => $item->sum('num')];
                                    })->toArray();

        dd($multiplied);
         //用于多条数据处理接口返回的数据结构处理，可以自由的组合
        return new UserResource(User::find(2));   //用于单个数据接口返回的数据结构处理，可以自由的组合
        //return $this->response([1, 2, 3]); //响应返回
        event(new MyEvent()); //触发事件
        if (is_numeric($request->input('key'))) { //通过$request获取到传过来的值，已经去过左右空格而且还可以却确定参数的类型
            echo $customServiceInstance->testServices();
        } else {
            echo '是字符串';
        }
    }

    /**
     * @Describe: 通过数据库 chunk 分批导出（推荐！）
     * @Author: chinwe.jing
     * @Data: 2018/8/21 15:37
     * @param ExcelZip $excelZip
     * @param Export $export
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Exception
     */
    public function export1(ExcelZip $excelZip, Export $export)
    {
        // set_time_limit(0); 提醒，小心脚本超时
        $excelZip = $excelZip->setExport($export);

        User::query()->chunk(5000, function ($members) use ($excelZip) {
            $excelZip->excel($members);
        });

        return $excelZip->zip();
    }

    /**
     * @Describe: 包内 chunk 实现（不推荐，如果数据量过大会出现 DB 层面的内存溢出）
     * @Author: chinwe.jing
     * @Data: 2018/8/21 15:37
     * @param ExcelZip $excelZip
     * @param Export $export
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export2(ExcelZip $excelZip, Export $export)
    {
        return $excelZip->download(User::all(), $export);
    }

    public function swoole()
    {
        $cli = new \Swoole\Coroutine\Http\Client('127.0.0.1', 80);
        $cli->setHeaders([
            'Host' => 'test.me',
        ]);
        $cli->get('/');
        $result = $cli->body;
        $cli->close();

        return response()->json($result);
    }
}
