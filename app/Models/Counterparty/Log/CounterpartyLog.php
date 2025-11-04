<?php

namespace App\Models\Counterparty\Log;

use App\Models\Counterparty\Counterparty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CounterpartyLog extends Model
{
    protected $table = 'counterparty_logs';

    protected $fillable = ['counterpart_id', 'status_id', 'message'];

    // Связи

    public function counterpart(): BelongsTo
    {
        return $this->belongsTo(Counterparty::class, 'counterpart_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(CounterpartyLogStatuses::class, 'status_id');
    }
}
