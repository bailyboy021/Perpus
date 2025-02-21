<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use App\Helpers\Mimetype;

class Book extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        if (isset($filters['is_available'])) {
            $query->where('is_available', $filters['is_available']);
        }

        return $query;
    }

    public static function deleteBook($id)
    {
        try {
            $buku = self::find($id);

            if (!$buku) {
                return [
                    'success' => false,
                    'message' => 'Book not found',
                    'status' => 400,
                ];
            }

            $buku->delete();

            return [
                'success' => true,
                'message' => 'Berhasil menghapus buku'
            ];
        } catch (\Exception $e) {
            Log::error('Gagal menghapus buku: ' . $e->getMessage());    
            return false;
        }
    }
}
