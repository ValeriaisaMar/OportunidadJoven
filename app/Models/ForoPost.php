<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ForoPost extends Model
{
    /** clave => etiqueta que se muestra. (Los colores están en components/foro/categoria.blade.php) */
    public const CATEGORIAS = [
        'experiencias' => 'Experiencias',
        'preguntas' => 'Preguntas',
        'consejos' => 'Consejos',
        'entrevistas' => 'Entrevistas',
    ];

    protected $table = 'foro_posts';

    protected $fillable = ['user_id', 'categoria', 'titulo', 'contenido'];

    protected $casts = ['vistas' => 'integer'];

    /** Al borrar una publicación se borran también sus comentarios y todos los votos. */
    protected static function booted(): void
    {
        static::deleting(function (ForoPost $post) {
            $post->comentarios->each->delete(); // cada comentario borra sus propios votos
            $post->votos()->delete();
        });
    }

    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comentarios(): HasMany
    {
        return $this->hasMany(ForoComentario::class, 'foro_post_id');
    }

    public function votos(): MorphMany
    {
        return $this->morphMany(ForoVoto::class, 'votable');
    }

    /**
     * Agrega la cantidad de "me gusta" y "no me gusta", y (si hay sesión)
     * el voto de esa persona, para pintar los botones activos.
     */
    public function scopeConVotos(Builder $query, ?int $userId = null): Builder
    {
        return $query
            ->withCount([
                'votos as likes_count' => fn ($q) => $q->where('valor', ForoVoto::ME_GUSTA),
                'votos as dislikes_count' => fn ($q) => $q->where('valor', ForoVoto::NO_ME_GUSTA),
            ])
            ->when($userId, fn ($q) => $q->with(['votos' => fn ($v) => $v->where('user_id', $userId)]));
    }

    public function etiquetaCategoria(): string
    {
        return self::CATEGORIAS[$this->categoria] ?? ucfirst($this->categoria);
    }
}
