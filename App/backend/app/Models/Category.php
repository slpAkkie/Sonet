<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'color',
    ];

    public function __construct(array $attributes = [])
    {
        $this->user_id = Auth::id();

        parent::__construct($attributes);
    }

    public function owner() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
