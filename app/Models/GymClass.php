<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GymClass extends Model{
    use HasFactory;

     /**
     * The table associated with the model.
     * Especificamos explícitamente que la tabla se llama 'class'.
     *
     * @var string
     */
    protected $table = 'class';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
     public $timestamps = false;

    protected $fillable = [
        'name',
        'start_time',
        'duration_minutes',
        'capacity',
        'id_categories',
        'id_instructor',
    ];
    

    
    public function category(): BelongsTo{
        return $this->belongsTo(Categories::class, 'id_categories');
    }

    public function instructor(): BelongsTo{
        return $this->belongsTo(User::class, 'id_instructor');
    }
    }



