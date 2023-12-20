<?php

namespace Workbench\App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Abather\MiniAccounting\Traits\HasAccountMovement;
use Abather\MiniAccounting\Workbench\Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Workbench\Database\Factories\UserFactory as WorkbenchUserFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable,
        HasAccountMovement;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function newFactory()
    {
        return WorkbenchUserFactory::new();
    }

    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class);
    }

    public function refunds(): HasMany
    {
        return $this->hasMany(Refund::class);
    }

    public function system()
    {
        return $this->belongsTo(System::class);
    }
}
