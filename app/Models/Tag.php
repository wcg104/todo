<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
       
        'title',
       
    ];
    public $timestamps = true;
    public function notes()
    {
        return $this->belongsToMany(Note::class,'note_tags');
    }
}
