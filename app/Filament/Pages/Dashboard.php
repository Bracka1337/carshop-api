<?php
 
namespace App\Filament\Pages;
use Filament\Panel;
 
class Dashboard extends \Filament\Pages\Dashboard
{
    
    public function panel(Panel $panel): Panel
    {
        
        return $panel
            ->pages([]);
    }
}