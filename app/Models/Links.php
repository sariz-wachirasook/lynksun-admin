<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'short_url',
        'name',
        'expires_at',
        'user_id',
    ];

    public function visitLogs()
    {
        return $this->hasMany(LinkVisitLogs::class);
    }
}
