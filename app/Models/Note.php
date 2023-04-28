<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Note extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'priority_level',
        'tag_id',
        'status',
        'archive',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function todo()
    {
        return $this->hasMany(Todo::class)->orderBy('index_no');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class,'note_tags');
    }
}
