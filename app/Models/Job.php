<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'jobs';

    // Specify the primary key column
    protected $primaryKey = 'id';

    // Specify that the primary key is a big integer and auto-incrementing
    public $incrementing = true;
    protected $keyType = 'bigint';

    // Set the timestamps fields if they are present in the table
    public $timestamps = true;

    // Define which attributes are mass assignable
    protected $fillable = [
        'queue',
        'attempts',
        'reserved_at',
        'available_at',
        'payload',
    ];

    // Optionally, you can define which attributes are cast to a specific data type
    protected $casts = [
        'reserved_at' => 'datetime',
        'available_at' => 'datetime',
    ];
}
