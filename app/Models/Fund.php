<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PhpParser\Node\Stmt\TraitUseAdaptation\Alias;

class Fund extends Model {
    use HasFactory;

    protected $table = 'funds';

    public function fund_manager(): BelongsTo {
        return $this->belongsTo(FundManager::class, 'fund_manager_id');
    }

    public function alias_funds(): HasMany {
        return $this->hasMany(Alias::class, 'fund_id', 'id');
    }
}
