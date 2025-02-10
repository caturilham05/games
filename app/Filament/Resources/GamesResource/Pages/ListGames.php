<?php

namespace App\Filament\Resources\GamesResource\Pages;

use App\Filament\Resources\GamesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Pages\Actions\Action;
use App\Models\Games;
use Filament\Notifications\Notification; // Import Notification

class ListGames extends ListRecords
{
    protected static string $resource = GamesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('sync')
                ->label('Sinkron Games')
                ->icon('heroicon-o-arrow-path') // Gunakan ikon yang valid
                ->color('success')
                ->action(function (Games $games){
                    $result = $games->sync_games();

                    if (!is_array($result)) {
                        Notification::make()
                            ->title('Terjadi Kesalahan')
                            ->body($result)
                            ->danger()
                            ->send();
                        return true;
                    }

                    Notification::make()
                        ->title('Sinkronisasi Berhasil')
                        ->success()
                        ->send();
                }) // Fungsi untuk sinkronisasi semua games
                ->requiresConfirmation()
                ->tooltip('Sinkronisasi semua data game'),

        ];
    }
}
