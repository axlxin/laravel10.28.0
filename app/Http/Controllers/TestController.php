<?php

namespace App\Http\Controllers;

use App\Common\Common;
use App\Http\Requests\InfoRequest;
use App\Http\Requests\PostRequest;
use App\Models\ErrorInfo;
use App\Models\Information;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use League\CommonMark\Extension\CommonMark\Node\Block\ThematicBreak;
use Mockery\Exception;
use function PHPUnit\Framework\isEmpty;

class TestController extends Controller
{

    /**
     * 获取请求信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function test(Request $request)
    {

        try {

            $requestId     = $_SERVER['HTTP_X_REQUEST_ID'];
            $requestMethod = $request->method();
            $requestPath   = $request->path();
            $requestAll    = $request->all()??[];
            $responseTxt   = $this->success();
            $responseTime  = $responseTxt['time']??"";
            $model                    =  new Information();
            $model-> request_id       =  $requestId;
            $model-> request_method   =  $requestMethod;
            $model-> request_path     =  $requestPath;
            $model-> request_data     =  json_encode($requestAll);
            $model-> response_context =  json_encode($responseTxt);
            $model-> response_time    =  $responseTime;
            $model-> save();
            return response()->json($responseTxt);


        }catch (\Exception $exception){
            $saveErr = new ErrorInfo();
            $data = ['message'=>json_encode($exception->getMessage()), 'trace' => json_encode($exception->getTrace()) ,'request_id' => $_SERVER['HTTP_X_REQUEST_ID']];
            $saveErr->saveErr($data);
            return response()->json([
                    'code'    => 500,
                    'status'  => 'ok',
                    'message' => '内部服务错误,请联系管理员(Internal service error, please contact the administrator)'
                ]);
        }


    }

    /**
     * 请求验证
     * @param PostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateData(PostRequest $request)
    {

        $validated = $request->validated();
        return response()->json([
            'code'    => 200,
            'status'  => 'ok',
            'message' => '您的数据验证已成功'
        ]);


    }

    /**
     * 内部代码错误
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function errors(Request $request)
    {

        try {

            $requestId     = $_SERVER['HTTP_X_REQUEST_ID'];
            $requestMethod = $request->method();
            $requestPath   = $request->path();
            $requestAll    = $request->all()??[];
            $responseTxt   = $this->success();
            $responseTime  = $responseTxt['time']??"";
            $model                    =  new Information();
            $model-> asdasd           =  $requestId;
            $model-> asdasd           =  $requestMethod;
            $model-> zxc              =  $requestPath;
            $model-> request_data     =  json_encode($requestAll);
            $model-> response_context =  json_encode($responseTxt);
            $model-> response_time    =  $responseTime;
            $model-> save();
            return response()->json($responseTxt);


        }catch (\Exception $exception){
            $saveErr = new ErrorInfo();
            $data = ['message'=>json_encode($exception->getMessage()), 'trace' => json_encode($exception->getTrace()) ,'request_id' => $_SERVER['HTTP_X_REQUEST_ID']];
            $saveErr->saveErr($data);
            return response()->json([
                'code'    => 500,
                'status'  => 'ok',
                'message' => '内部服务错误,请联系管理员(Internal service error, please contact the administrator)'
            ]);
        }

    }


    /**
     * 验证字符
     * @throws HttpClientException
     */
    public function characters(Request $request)
    {
        try {
            $str  = $request->query('s');

            if(empty($str) || $str == ''){
                return response()->json([
                    'code'    => 404,
                    'status'  => 'fail',
                    'message' => '参数不能为空(Param is not null)'
                ]);
            }

            $length = strlen($str);
            if(1 <= $length && 10000 >= $length)  //判定
            {
                $newStr = str_split($str);
                $chaStr = ["{",'}',"(",")","[","]"];
                foreach ($newStr as $k => $v){

                    if(!in_array($v,$chaStr)){

                       return response()->json([
                        'code'     =>   404,
                        'status'   =>  'fail',
                        'message'  =>  's consists of parentheses only "()[]{}"'
                      ]);

                    }
                }
            }

            return response()->json([
                'code'    => 200,
                'status'  => 'ok',
                'message' => $this->cal($str)
            ]);

        }catch (\Exception $exception){
            Log::alert('内部服务出错');
        }


    }


    /**
     * 逻辑
     * @param $str
     * @return bool
     */
    public function cal($str)
    {

        $arr    = str_split($str);
        $length = strlen($str);
        $newArr = [];
        for($i=0; $i<$length; $i++ ){

            if($arr[$i]  == '(' || $arr[$i] == '{' || $arr[$i] == '['){

                $newArr[] = $arr[$i];

            }
            if($arr[$i] == ')' || $arr[$i] == '}' || $arr[$i] == ']'){

                if(empty($newArr)) {
                    return  false;
                }

                $temp = array_pop($newArr);

                if(($temp == '(' && $arr[$i] == ')') || ($temp == '{' && $arr[$i] == '}') || ($temp == '[' && $arr[$i] == ']')){
                    continue;
                }else{
                    return false;
                }
            }
        }

        if(!empty($newArr))return false;

        return true;

    }






}
