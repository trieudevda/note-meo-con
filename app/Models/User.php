<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
enum StatusActive: string {
        case ACTIVE = 'active';
        case DEACTIVE = 'deactive';
    };
class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens;
    
    protected $casts = [
        'status'=>StatusActive::class,
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'password',
        'status',
        'api_token',
        'permission',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        // 'api_token',
        'status',
        'permission'
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
}
