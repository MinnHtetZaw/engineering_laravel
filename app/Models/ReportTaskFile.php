<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportTaskFile extends Model
{
    use HasFactory;

    protected $fillable =[
        'report_task_id',
        'file_type',
        'file'
    ];

    public function getFileTypeAttribute($type)
    {
        switch ($type) {
            case '1':
              return "image";
                break;
            case '2':
              return "video";
                break;
        }
    }
}
