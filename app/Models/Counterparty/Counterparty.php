<?php

namespace App\Models\Counterparty;

use App\Models\Counterparty\Log\CounterpartyLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Counterparty extends Model
{
    protected $fillable = [
        'user_id',
        'inn',
        'name',
        'ogrn',
        'address'
    ];

    // Связи

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(CounterpartyLog::class);
    }
}
