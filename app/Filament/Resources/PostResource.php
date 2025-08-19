<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Tables;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Tiptap\Extensions\TextAlign;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('User')
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('subtitle')
                    ->maxLength(255)
                    ->default(null),
                FileUpload::make('featured_image')
                    ->image()
                    ->imageEditor(),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                TiptapEditor::make('content')
                    ->profile('default')
                    ->tools([
                        'heading',
                        'bullet-list',
                        'ordered-list',
                        'link',
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'align-left',  // Add these alignment tools
                        'align-center',
                        'align-right',
                        'align-justify',
                        'blockquote',
                        'code-block',
                        'hr',
                    ])
                    ->columnSpanFull(),
                Forms\Components\Repeater::make('comments')
                    ->relationship('comments')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required()
                            ->label('User'),
                        Forms\Components\Textarea::make('content')
                            ->required()
                            ->label('Comment'),
                        Forms\Components\Repeater::make('replies')
                            ->schema([
                                Forms\Components\Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->required()
                                    ->label('User'),
                                Forms\Components\Textarea::make('content')
                                    ->required()
                                    ->label('Reply'),
                            ])
                            ->columnSpanFull()
                            ->defaultItems(0)
                            ->addActionLabel('Add Reply')
                            ->collapsible()
                            ->itemLabel(fn(array $state): ?string => $state['content'] ?? null),
                    ])
                    ->mutateRelationshipDataBeforeCreateUsing(function (array $data, $record): array {
                        $data['user_id'] = $data['user_id'] ?? 1;

                        // Handle replies
                        if (isset($data['replies'])) {
                            foreach ($data['replies'] as &$reply) {
                                $reply['user_id'] = $reply['user_id'] ?? 1;
                                $reply['post_id'] = $record->id;
                            }
                        }

                        return $data;
                    })
                    ->mutateRelationshipDataBeforeSaveUsing(function (array $data, $record): array {
                        $data['user_id'] = $data['user_id'] ?? 1;

                        // Handle replies
                        if (isset($data['replies'])) {
                            foreach ($data['replies'] as &$reply) {
                                $reply['user_id'] = $reply['user_id'] ?? 1;
                                $reply['post_id'] = $record->post_id ?? $record->id;
                            }
                        }

                        return $data;
                    })
                    ->saveRelationshipsUsing(function ($component, $state, $record) {
                        // Get all existing comment IDs that should be kept
                        $existingCommentIds = collect($state)
                            ->filter(fn($item) => isset($item['id']))
                            ->pluck('id');

                        // Delete comments that are not in the current state
                        $record->comments()->whereNotIn('id', $existingCommentIds)->delete();

                        foreach ($state as $commentData) {
                            $comment = null;

                            // Create or update the comment
                            if (isset($commentData['id']) && !empty($commentData['id'])) {
                                // Try to find existing comment
                                $comment = $record->comments()->find($commentData['id']);

                                if ($comment) {
                                    // Update existing comment
                                    $comment->update([
                                        'user_id' => $commentData['user_id'],
                                        'content' => $commentData['content'],
                                    ]);
                                } else {
                                    // Comment not found, create new one
                                    $commentDataForCreate = $commentData;
                                    unset($commentDataForCreate['id']);  // Remove ID for creation
                                    unset($commentDataForCreate['replies']);  // Remove replies for creation

                                    $comment = $record->comments()->create([
                                        'user_id' => $commentData['user_id'],
                                        'content' => $commentData['content'],
                                    ]);
                                }
                            } else {
                                // Create new comment
                                $comment = $record->comments()->create([
                                    'user_id' => $commentData['user_id'],
                                    'content' => $commentData['content'],
                                ]);
                            }

                            // Handle replies if comment was created/updated successfully
                            if ($comment && isset($commentData['replies']) && is_array($commentData['replies'])) {
                                // Get existing reply IDs that should be kept
                                $existingReplyIds = collect($commentData['replies'])
                                    ->filter(fn($reply) => isset($reply['id']) && !empty($reply['id']))
                                    ->pluck('id');

                                // Delete replies not in current state
                                $comment->replies()->whereNotIn('id', $existingReplyIds)->delete();

                                // Create or update replies
                                foreach ($commentData['replies'] as $replyData) {
                                    if (isset($replyData['id']) && !empty($replyData['id'])) {
                                        // Try to update existing reply
                                        $existingReply = $comment->replies()->find($replyData['id']);

                                        if ($existingReply) {
                                            $existingReply->update([
                                                'user_id' => $replyData['user_id'],
                                                'content' => $replyData['content'],
                                                'post_id' => $record->id,
                                            ]);
                                        } else {
                                            // Reply not found, create new one
                                            $comment->replies()->create([
                                                'user_id' => $replyData['user_id'],
                                                'content' => $replyData['content'],
                                                'post_id' => $record->id,
                                            ]);
                                        }
                                    } else {
                                        // Create new reply
                                        $comment->replies()->create([
                                            'user_id' => $replyData['user_id'],
                                            'content' => $replyData['content'],
                                            'post_id' => $record->id,
                                        ]);
                                    }
                                }
                            }
                        }
                    })
                    ->columnSpanFull()
                    ->defaultItems(0)
                    ->addActionLabel('Add Comment')
                    ->collapsible()
                    ->itemLabel(fn(array $state): ?string => $state['content'] ?? null),
                Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subtitle')
                    ->searchable()
                    ->limit(20),
                ImageColumn::make('featured_image')
                    ->circular(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->limit(20),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('content')
                    ->markdown()
                    ->limit(50),
                Tables\Columns\TextColumn::make('comments_count')
                    ->counts('comments'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}