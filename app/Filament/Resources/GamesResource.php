<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GamesResource\Pages;
use App\Filament\Resources\GamesResource\RelationManagers;
use App\Models\Games;
use App\Models\Game_detail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification; // Import Notification
use Illuminate\Support\Facades\Log;

class GamesResource extends Resource
{
    protected static ?string $model = Games::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->maxLength(255),
                Forms\Components\TextInput::make('thumbnail')
                    ->maxLength(255),
                Forms\Components\Textarea::make('short_description')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('game_url')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('genre')
                    ->maxLength(255),
                Forms\Components\TextInput::make('platform')
                    ->maxLength(255),
                Forms\Components\TextInput::make('publisher')
                    ->maxLength(255),
                Forms\Components\TextInput::make('developer')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('release_date'),
                Forms\Components\TextInput::make('freetogame_profile_url')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('thumbnail')
                    ->searchable(),
                Tables\Columns\TextColumn::make('genre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('platform')
                    ->searchable(),
                Tables\Columns\TextColumn::make('publisher')
                    ->searchable(),
                Tables\Columns\TextColumn::make('developer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('release_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('freetogame_profile_url')
                    ->searchable(),
                Tables\Columns\IconColumn::make('game_detail_data')
                    ->label('Status Sinkronisasi')
                    ->icon(fn (Games $record) => $record->game_detail_data->isEmpty() ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn (Games $record) => $record->game_detail_data->isEmpty() ? 'danger' : 'success')
                    ->tooltip(fn (Games $record) => $record->game_detail_data->isEmpty() ? 'Belum tersinkron' : 'Sudah tersinkron'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Action::make('sync')
                    ->label('Sinkron Games')
                    ->icon('heroicon-o-arrow-path') // Ikon refresh terbaru
                    ->color('primary')
                    ->action(function (Games $record) {
                        try {
                            // Panggil method sinkronisasi
                            Games::game_detail_sync($record);

                            // Notifikasi sukses
                            Notification::make()
                                ->title('Sinkronisasi Berhasil')
                                ->body('Data detail game telah berhasil disinkronisasi.')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            // Notifikasi gagal
                            Notification::make()
                                ->title('Sinkronisasi Gagal')
                                ->body('Terjadi kesalahan saat menyinkronisasi data: ' . $e->getMessage())
                                ->danger()
                                ->send();
                        }
                    })
                    // ->action(fn (Games $record) => Games::game_detail_sync($record))
                    ->requiresConfirmation()
                    ->tooltip('Sinkronisasi data game ini')
                    ->visible(fn (Games $record) => $record->game_detail_data->isEmpty()) // Hanya muncul jika game_detail_data kosong
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGames::route('/'),
            'create' => Pages\CreateGames::route('/create'),
            'view' => Pages\ViewGames::route('/{record}'),
            'edit' => Pages\EditGames::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
