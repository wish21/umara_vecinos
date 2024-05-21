<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $modelLabel = 'Usuario';
    protected static ?int $navigationSort = 0;
    protected static ?string $navigationGroup = 'Roles y Permisos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->hiddenOn('edit')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('roles')->multiple()->relationship('roles','name')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            //
            Tables\Columns\TextColumn::make('name')
                ->label('Nombre')
                ->searchable(),

            Tables\Columns\TextColumn::make('email')
                ->label('Email')
                ->searchable(),
            Tables\Columns\TextColumn::make('email_verified_at')
                ->label('Fecha Verificado')
                ->searchable(),
            Tables\Columns\TextColumn::make('roles.name')
                ->label('Rol')
                ->searchable(),
        ])
            ->filters([
                //
                Tables\Filters\Filter::make('verified')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),
            ])
            ->actions([
                Tables\Actions\Action::make('verify')
                    ->icon('heroicon-m-check-badge')
                    ->iconButton()
                    ->tooltip('Verificar')
                    ->action(function(User $user){
                        $user->email_verified_at = Date('Y-m-d H:i:s');
                        $user->save();
                    }),
                Tables\Actions\EditAction::make()->iconButton()->tooltip('Editar'),
                Tables\Actions\DeleteAction::make()->iconButton()->tooltip('Eliminar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}