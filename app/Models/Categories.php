<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 
use Illuminate\Database\Eloquent\Relations\HasMany;  
use App\Models\Scopes\TenantScope;
use Illuminate\Support\Facades\Auth;


class Categories extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;

    protected $fillable = [
        'name',
        'icon', 
        'max_user_signups_per_period',
        'tenant_id',
    ];

        protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);

        static::creating(function ($category) {
          
            if (is_null($category->tenant_id) && Auth::check() && Auth::user()->tenant_id) {
                $category->tenant_id = Auth::user()->tenant_id;
            }

        });
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function gymClasses()
     {
         return $this->hasMany(GymClass::class, 'id_categories');
     }
}
