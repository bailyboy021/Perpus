<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Loan extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        if (isset($filters['is_available'])) {
            $query->where('is_available', $filters['is_available']);
        }

        return $query;
    }
}
