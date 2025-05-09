<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected  static ?string $navigationLabel = 'دسته بندی ها';
    protected  static ?string $pluralModelLabel = 'دسته بندی ها';
    protected  static ?string $modelLabel = 'دسته بندی';
    protected  static ?string $navigationGroup = 'محصول ها';
    protected  static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('parent_id')
                    ->label('دسته بندی اصلی')
                    ->relationship('parent', 'name',
                        fn(Builder $query) => $query->whereNull('parent_id'))
                   ->searchable()->placeholder('دسته بندی اصلی ')->preload(),
                Forms\Components\TextInput::make('name')
                    ->label('دسته بندی')
                    ->required()
//                ->live()
//                ->afterStateUpdated(function (Forms\Set $set ,$state) {
//                      $set('slug', Str::slug($state));
//                }),
//                Forms\Components\TextInput::make('slug')
//                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('parent.name')
                    ->label('دسته  بندی اصلی')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(' نام دسته بندی')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            RelationManagers\ProductsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
