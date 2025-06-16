<?php

namespace App\Filament\Resources\ChatbotConversationResource\Pages;

use App\Filament\Resources\ChatbotConversationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChatbotConversation extends EditRecord
{
    protected static string $resource = ChatbotConversationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ViewAction::make(),
        ];
    }
} 