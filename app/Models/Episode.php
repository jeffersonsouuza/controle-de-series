<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Episode extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['number'];
    protected $casts = ['watched' => 'boolean'];

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

//    protected function watched(): Attribute
//    {
//        return new Attribute(
//            get: fn($watched) => (bool) $watched
//        );
//    }

}
