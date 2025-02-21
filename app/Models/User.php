<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public static function store(array $params = [])
    {
        try {
            $data = [
                'name' => $params['nama'],
                'email' => $params['email'],
                'password' => Hash::make($params['password']),
                'role_id' => $params['role'],
            ];

            $user = self::create($data);

            return $user;

        } catch (\Exception $e) {
            Log::error('Gagal menambahkan data User : ' . $e->getMessage());
            return false;
        }
    }
    
    public static function deleteUser($id)
    {
        try {
            $user = self::find($id);

            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'User not found',
                    'status' => 400,
                ];
            }

            $user->delete();

            return [
                'success' => true,
                'message' => 'Berhasil menghapus user',
            ];
        } catch (\Exception $e) {
            Log::error('Gagal menghapus user: ' . $e->getMessage());    
            return false;
        }
    }
}
