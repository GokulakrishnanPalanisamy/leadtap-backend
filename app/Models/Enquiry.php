<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable(['name', 'email', 'phone', 'message', 'wp_post_id'])]


class Enquiry extends Model
{
    use HasFactory;

    protected $attributes = [
        'status' => 'pending',
    ];

    protected static function booted()
    {
        static::creating(function ($enquiry) {
            $enquiry->uuid = Str::uuid();
        });
    }
}
