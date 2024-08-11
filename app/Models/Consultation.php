<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;
    protected $table = 'consultations';
    protected $fillable = [
        'user_id',
        'professional_id',
        'scheduled_at',
        'notes',
    ];
}
