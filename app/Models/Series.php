<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Series extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'cover'];
    protected $with = ['seasons'];
    protected $appends = ['links'];

    /*
     * mapear os relacionamentos entre nossas tabelas do banco de dados usando Eloquent ORM é bastante simples.
     */

    public function seasons(): HasMany
    {
        return $this->hasMany(Season::class, 'series_id');
    }

    public function episodes(): HasManyThrough
    {
        return $this->hasManyThrough(Episode::class, Season::class);
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

    public function links(): Attribute
    {
        return new Attribute(
            get: fn() => [
                [
                   'rel' => 'self',
                   'url' => "/api/series/{$this->id}",
                ],
                [
                    'rel' => 'seasons',
                    'url' => "/api/series/{$this->id}/seasons",
                ],
                [
                    'rel' => 'episodes',
                    'url' => "/api/series/{$this->id}/episodes",
                ],
            ]
        );
    }

}
