<?php

namespace App\Filament\Resources\ChatbotConversationResource\Pages;

use App\Filament\Resources\ChatbotConversationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewChatbotConversation extends ViewRecord
{
    protected static string $resource = ChatbotConversationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
} 