<?php


namespace App\Settings; 

use Spatie\LaravelSettings\Settings; 

class AppearanceSettings extends Settings 
{
    
    public ?string $app_logo = null;
    public string $app_color = '#4f46e5';

    public static function group(): string
    {
        return 'appearance';
    }
}

