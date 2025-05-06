<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Resources\Pages\Page;

class UserInfo extends Page
{
    protected static string $resource = UserResource::class;

    protected static string $view = 'filament.resources.user-resource.pages.user-info';

    public $user;
    public function mount($record)
    {
        $this->user = User::query()->findOrFail($record);
    }
}
