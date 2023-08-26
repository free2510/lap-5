<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Filament\Resources\BlogResource\RelationManagers;
use App\Models\Blog;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;
    public function store(Form $form)
    {
        $record = $form->save();

        if ($form->hasUploadedFile('image')) {
            $record->addMediaFromRequest('image')->toMediaCollection('images');
        }

        return $this->redirect(route('filament.resource.index', static::$model));
    }
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('title')->required(),
                Textarea::make('content')->required()->cols(20),
                FileUpload::make('image')
                    ->image(),
                TextInput::make('tags')->required()


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->limit(20),
                TextColumn::make('content')->limit(20),
                TextColumn::make('users_id'),
                TextColumn::make('categories_id'),
            ImageColumn::make('image')
            ->square()
            ->size(40)
            ->url(function ($record) {
                $image = $record->getFirstMedia('images');
                if ($image) {
                    return $image->getFullUrl();
                }
                return null;
            }),
                TextColumn::make('tags')->limit(20)
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
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
