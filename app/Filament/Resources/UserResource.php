<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

     protected  static ?string $navigationLabel = 'کاربران';
     protected  static ?string $pluralModelLabel = 'کاربران';
     protected  static ?string $modelLabel = 'کاربر';
    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected  static ?string $navigationGroup = 'تنظیمات';
    protected  static ?int $navigationSort = 0;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('نام و نام خانوادگی')
                    ->required()
                    ->minLength(3),
                TextInput::make('email')
                    ->required()
                    ->label('ایمیل')
                    ->email()
                    ->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->required(fn (string $context):bool => $context == 'create')
                    ->dehydrated(fn($state)=> filled($state))
                    ->label('رمز عبور')
                    ->minLength(6),
                Select::make('roles')->multiple()->relationship('roles', 'name')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('نام و نام خانوادگی'),
                TextColumn::make('email')->label('ایمیل'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('info')
                    ->label('جزئیات کاربر')
                    ->url(fn (Model $record): string =>
                    route('filament.admin.resources.users.user_info',['record'=>$record])),
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
            'user_info' => Pages\UserInfo::route('/{record}/user_info'),
        ];
    }
}
