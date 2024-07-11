<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpamEmail extends Model
{
    use HasFactory;

    protected $fillable = ['email'];
}
