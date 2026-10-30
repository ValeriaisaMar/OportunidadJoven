<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ForoVoto extends Model
{
    public const ME_GUSTA = 1;
    public const NO_ME_GUSTA = -1;

    protected $table = 'foro_votos';

    protected $fillable = ['user_id', 'valor'];

    protected $casts = ['valor' => 'integer'];

    /** Lo que se votó: una publicación o un comentario. */
    public function votable(): MorphTo
    {
        return $this->morphTo();
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
