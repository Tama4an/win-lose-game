<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'history';
    protected $fillable = [
        'link_id',
        'random_number',
        'result',
        'win_amount'
    ];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}
