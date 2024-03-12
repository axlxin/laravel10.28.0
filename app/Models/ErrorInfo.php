<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErrorInfo extends Model
{
    use HasFactory;

    /**
     * 与模型关联的数据表.
     *
     * @var string
     */
    protected $table = 'error_info';

    /**
     * 指示模型是否主动维护时间戳。
     *
     * @var bool
     */
    public $timestamps = true;


    public function saveErr($data = [])
    {
        $model = new ErrorInfo();
        $model->error_message = $data['message'];
        $model->trace         = $data['trace'];
        $model->request_id    = $data['request_id'];
        $model->save();
    }


}
