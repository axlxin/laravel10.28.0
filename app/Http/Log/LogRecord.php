<?php

namespace App\Http\Log;
use Illuminate\Log\Writer;
use Illuminate\Support\Facades\Log;

class LogRecord
{
    public function log(){
        Log::emergency("系统挂掉了");
        Log::alert("数据库访问异常");
        Log::critical("系统出现未知错误");
        Log::error("指定变量不存在");
        Log::warning("该方法已经被废弃");
        Log::notice("用户在异地登录");
        Log::info("用户xxx登录成功");
        Log::debug("调试信息");
    }

}
