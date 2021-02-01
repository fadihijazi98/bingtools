<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubnetIps extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $appends = ['checked_at', 'a_record']; // a_recorde === the value in PTR column in view ..

    public function getCheckedAtAttribute() {

        return $this->updated_at->diffForHumans();

    }

    public function getARecordAttribute() {

        return gethostbyaddr($this->ip);

    }

}
