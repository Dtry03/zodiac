<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable; 
use Illuminate\Database\Eloquent\Relations\HasMany; 

class Tenant extends Model
{
    use HasFactory, Billable; 

    /**
     * The table associated with the model.
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'stripe_id',
        'pm_type',
        'pm_last_four',
        'trial_ends_at',
        'subscription_status',
        'subscribed_at',
        'subscription_ends_at',
        'grace_period_ends_at',
        'logo_path', 
        'theme_color', 
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'trial_ends_at' => 'datetime',
        'subscribed_at' => 'datetime',
        'subscription_ends_at' => 'datetime',
        'grace_period_ends_at' => 'datetime',
    ];

    /**
     * Get the users associated with the tenant.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the categories associated with the tenant.
     */
    public function categories(): HasMany
    {
        return $this->hasMany(Categories::class);
    }

    /**
     * Get the gym classes associated with the tenant.
     */
    public function gymClasses(): HasMany
    {
        return $this->hasMany(GymClass::class);
    }

}