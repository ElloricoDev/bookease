<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['user_id', 'book_id', 'days', 'fee', 'deposit', 'status'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
