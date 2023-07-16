<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AliasFund extends Model
{
    use HasFactory;

    protected $table = 'alias_funds';

    public function fund(): BelongsTo {
        return $this->belongsTo(Fund::class, 'fund_id');
    }
}
