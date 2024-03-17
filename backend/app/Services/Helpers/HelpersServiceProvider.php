<?php

namespace App\Services\Helpers;

use App\Services\Helpers\Encryption\EncryptionHelper;
use App\Services\Helpers\Encryption\EncryptionHelperService;
use App\Services\Helpers\Files\FilesHelper;
use App\Services\Helpers\Files\FilesHelperService;
use App\Services\Helpers\Images\ImageHelper;
use App\Services\Helpers\Images\ImageHelperService;
use Illuminate\Support\ServiceProvider;

class HelpersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ImageHelperService::class, ImageHelper::class);
    }
}
