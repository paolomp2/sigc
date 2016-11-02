<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Domain extends Model
{
    use SoftDeletes;

	protected $dates = ['deleted_at'];
    protected $table = 'domain';

    public function CreatedBy()
    {
    	return $this->belongsTo('App\User','created_by');
    }
}
