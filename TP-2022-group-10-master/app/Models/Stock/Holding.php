<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holding extends Model
{
    use HasFactory;
    protected $table = 'holdings';
    protected $fillable = ['user_id', "symbol", "quantity","order_value","total_order_value","total_value","changes"];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
