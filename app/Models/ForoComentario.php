<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ForoComentario extends Model
{
    protected $table = 'foro_comentarios';

    protected $fillable = ['foro_post_id', 'user_id', 'contenido'];

    /** Al borrar un comentario se borran también sus votos. */
    protected static function booted(): void
    {
        static::deleting(fn (ForoComentario $comentario) => $comentario->votos()->delete());
    }

    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(ForoPost::class, 'foro_post_id');
    }

    public function votos(): MorphMany
    {
        return $this->morphMany(ForoVoto::class, 'votable');
    }

    /** Igual que en ForoPost: conteo de votos + el voto de la persona con sesión. */
    public function scopeConVotos(Builder $query, ?int $userId = null): Builder
    {
        return $query
            ->withCount([
                'votos as likes_count' => fn ($q) => $q->where('valor', ForoVoto::ME_GUSTA),
                'votos as dislikes_count' => fn ($q) => $q->where('valor', ForoVoto::NO_ME_GUSTA),
            ])
            ->when($userId, fn ($q) => $q->with(['votos' => fn ($v) => $v->where('user_id', $userId)]));
    }
}
