<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'note_id',
        'title',
        'status',
        'index_no',
        'user_id',
        'file',
    ];
    public $timestamps = true;
    public function note()
    {
        return $this->belongsTo(Note::class);
    }
}
