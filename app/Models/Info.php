<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'body',
        'link',
        'image',
        'user_id',
        'category',
        'replay',
        'image_file_name',
        'addressee'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
