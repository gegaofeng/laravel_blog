<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobTest extends Model
{
    //
    //    public $table='jobtests';
    public function store(string $queuename)
    {
        $JobTest = new JobTest();
        $JobTest->queuename = $queuename;
        $JobTest->save();
    }
}
