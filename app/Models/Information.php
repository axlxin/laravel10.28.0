<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    /**
     * 与模型关联的数据表.
     *
     * @var string
     */
    protected $table = 'information';

    /**
     * 指示模型是否主动维护时间戳。
     *
     * @var bool
     */
    public $timestamps = true;

    public function find()
    {
        $data  = Information::where('id', 1)
            ->get();

        return $data;
    }

}
