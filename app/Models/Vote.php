<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;
    protected $table = 'vote';
    protected $fillable = ['vote'];
    
    public function blog() {
        return $this->belongsTo(Blog::class);
    }
}
