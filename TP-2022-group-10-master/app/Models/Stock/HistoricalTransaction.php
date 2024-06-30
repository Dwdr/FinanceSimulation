<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricalTransaction extends Model
{
    use HasFactory;
    protected $table = 'historical_transactions';
    protected $fillable = ['user_id', "symbol", "quantity","order_value","total_order_value","total_value","changes","transaction_date"];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
