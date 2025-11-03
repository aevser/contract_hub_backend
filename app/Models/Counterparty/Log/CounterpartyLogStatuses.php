<?php

namespace App\Models\Counterparty\Log;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CounterpartyLogStatuses extends Model
{
    protected $table = 'counterparty_log_statuses';

    protected $fillable = ['name', 'type'];

    // Связи

    public function logs(): HasMany
    {
        return $this->hasMany(CounterpartyLog::class);
    }
}
