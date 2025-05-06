<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    /**
     * Run the settings migration.
     */
    public function up(): void
    {

        $this->migrator->add('appearance.app_logo', null);


        $this->migrator->add('appearance.app_color', '#4f46e5'); 
    }

};