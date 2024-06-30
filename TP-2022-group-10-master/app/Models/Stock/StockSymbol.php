<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockSymbol extends Model
{
    use HasFactory;
    protected $table = 'stock_symbols';
    protected $fillable = ['symbol'];
}
