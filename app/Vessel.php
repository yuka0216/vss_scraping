<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vessel extends Model
{
    protected $dates = [
        'eta',
    ];
    protected $dateFormat = 'Y-m-d H:i';
} 



