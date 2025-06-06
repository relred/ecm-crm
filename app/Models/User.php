<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'username', 'password', 'public_password', 'role',
        'email', 'phone', 'state', 'municipality',
        'photo', 'parent_id',
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

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    // Relationships
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    public function promoted()
    {
        return $this->hasMany(Promoted::class, 'created_by');
    }

    public function childrenPromoted()
    {
        return $this->hasManyThrough(
            Promoted::class,
            User::class,
            'parent_id', // Foreign key on users table
            'created_by', // Foreign key on promoted table
            'id', // Local key on users table
            'id' // Local key on users table
        );
    }

    public function touchesPerformed()
    {
        return $this->hasMany(Touch::class);
    }

    public function mobilizationActivity()
    {
        return $this->hasOne(MobilizationActivity::class);
    }

    // Role scopes
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function isAdmin() { return $this->role === 'admin'; }
    public function isCoordinator() { return $this->role === 'coordinator'; }
    public function isOperator() { return $this->role === 'operator'; }
    public function isSubcoordinator() { return $this->role === 'subcoordinator'; }
    public function isPromoter() { return $this->role === 'promoter'; }
    public function isMonitor() { return $this->role === 'monitor'; }
}
