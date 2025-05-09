<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';
    protected  static ?string $modelLabel = 'محصول';
    protected  static ?string $inverseRelationship = 'محصول ها';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                   ->live()
                ->afterStateUpdated(function (Forms\Set $set ,$state) {
                     $set('slug', Str::slug($state));
                }),
                   Forms\Components\Hidden::make('slug')
                  ->required(),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->suffix('تومان'),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->disk('filament')
                    ->directory('products')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->suffix(' تومان ')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image')
                    ->disk('filament')->circular(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->beforeFormFilled(function (Product $product) {
                    $product['slug'] = Str::slug($product['title']);
                })
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
}
