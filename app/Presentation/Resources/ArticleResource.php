<?php

namespace App\Presentation\Resources;

use App\Models\Article;
use App\Presentation\Resources\ArticleResource\Pages;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->label('記事タイトル')->required(),
                TextInput::make('link')->label('リンク')->required(),
                Select::make('service')
                ->label('サービス')
                ->options([
                    'Qiita' => 'Qiita',
                    'Zenn' => 'Zenn',
                    'モチヤブログ' => 'モチヤブログ',
                ])
                ->required()
                ->placeholder('サービスを選択'),
                DatePicker::make('published')->label('公開日')->required(),
                Toggle::make('is_pickup')->label('注目記事に表示する')->required(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('link'),
                ToggleColumn::make('is_pickup'),
                TextColumn::make('published'),
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
