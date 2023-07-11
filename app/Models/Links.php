<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    use HasFactory;

    public function visitLogs()
    {
        return $this->hasMany(LinkVisitLogs::class);
    }
}
