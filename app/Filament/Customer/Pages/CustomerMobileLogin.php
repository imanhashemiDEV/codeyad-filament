<?php

namespace App\Filament\Customer\Pages;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Login;
use Filament\Pages\Page;

class CustomerMobileLogin extends Login
{

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('mobile')
            ->label('mobile')
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'mobile' => $data['mobile'],
            'password' => $data['password'],
        ];
    }

}
