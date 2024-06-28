<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $modelLabel = 'Pagos';

    public static function form(Form $form): Form
    {
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        return $form
            ->schema([
                Forms\Components\Select::make('house_id')
                    ->relationship('house', 'number')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->street} {$record->number}")
                    ->required(),
                Forms\Components\DatePicker::make('pay_date')
                    ->required(),
                Forms\Components\TextInput::make('concept')
                    ->required()
                    ->default('Mensualidad del mes: '. $meses[date('n') - 1].' - '.date('Y'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->default('300')
                    ->required(),
                Forms\Components\Select::make('type')
                    ->options([
                        'mensual' => 'Mensual',
                        'extraordinaria' => 'Extraordinaria',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {

        return $table

        ->modifyQueryUsing(function (Builder $query) {
            if (auth()->user()->roles[0]['name']=== 'Vecino') {
                $houses = DB::table('houses')->where('user_id',auth()->user()->id)->get('id');
                return $query->where('house_id', $houses[0]->id);
            }
            if (auth()->user()->roles[0]['name'] === 'Administrador') {
                return $query;
            }
        })

            ->columns([
                Tables\Columns\TextColumn::make('house.number')
                ->label('House')
                ->formatStateUsing(function ($state, Model $order) {
                    return $order->house->street . ' ' . $order->house->number;
                }),
                Tables\Columns\TextColumn::make('pay_date')->date(),
                Tables\Columns\TextColumn::make('amount')->money('MXN'),
                Tables\Columns\TextColumn::make('type'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}