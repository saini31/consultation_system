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
    // Relationship to the user who scheduled the consultation
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship to the professional handling the consultation
    public function professional()
    {
        return $this->belongsTo(User::class, 'professional_id');
    }
}
