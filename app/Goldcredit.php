<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goldcredit extends Model
{
    protected $fillable = ['credit_value', 'gold_date', 'gold_usd', 'gold_cad', 'note'];
    
    public function goldcredit()
    {
        return $this->belongsTo(Goldcredit::class);
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

}