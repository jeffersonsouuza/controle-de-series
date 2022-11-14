<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Series extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'cover'];
    protected $with = ['seasons'];

    /*
     * mapear os relacionamentos entre nossas tabelas do banco de dados usando Eloquent ORM é bastante simples.
     */

    public function seasons(): HasMany
    {
        return $this->hasMany(Season::class, 'series_id');
    }

    /*
     * faz a ordenação.
     * escopo global.
     */
    protected static function booted(): void
    {
        self::addGlobalScope('ordered', static function (Builder $queryBuilder) {
            $queryBuilder->orderBy('nome');
        });
    }

    /*
     * escopo local
     */
//    public function scopeActive(Builder $query): Builder
//    {
//        return $query->where('active', true);
//    }

}
