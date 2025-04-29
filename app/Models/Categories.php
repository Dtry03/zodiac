<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


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
    ];

    // public function gymClasses()
    // {
    //     return $this->hasMany(GymClass::class, 'id_categoria');
    // }
}
