<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sale extends Model
{
    use HasFactory;

    protected $fillable = ['customer', 'total_amount'];

   

    public function saleItems()
    {
        return $this->hasMany(sales_items::class);
    }
}
