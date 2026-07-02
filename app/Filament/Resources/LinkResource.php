<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LinkResource\Pages;
use App\Filament\Resources\LinkResource\RelationManagers;
use App\Models\Link;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Tables\Actions\DeleteAction;

class LinkResource extends Resource
{
    protected static ?string $model = Link::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('original_url')
                    ->url()
                    ->required()
                    ->placeholder('https://example.com/some-long-page')
                    ->maxLength(2048),
                
                Forms\Components\Hidden::make('short_code')
                    ->default(fn () => Str::random(6))
                    ->required(),
                    
                Forms\Components\Hidden::make('user_id')
                    ->default(fn () => auth()->id()),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('original_url')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('short_code')
                    ->label('Короткая ссылка')
                    ->formatStateUsing(fn ($state) => url('/' . $state))
                    ->copyable(),
                Tables\Columns\TextColumn::make('clicks_count')
                    ->counts('clicks')
                    ->label('Переходы'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Создано'),
            ])
            ->actions([
                DeleteAction::make(),
            ]);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ClicksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLinks::route('/'),
            'create' => Pages\CreateLink::route('/create'),
            'edit' => Pages\EditLink::route('/{record}/edit'),
        ];
    }
}
