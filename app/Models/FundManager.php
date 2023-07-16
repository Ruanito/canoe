<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FundManager extends Model {
    use HasFactory;

    protected $table = 'fund_managers';

    public function funds(): HasMany {
        return $this->hasMany(Fund::class, 'fund_manager_id', 'id');
    }
}
