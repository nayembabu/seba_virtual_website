<?php

namespace App\Providers;

use App\Models\ContentDetails;
use App\Models\Fund;
use App\Models\Gateway;
use App\Models\Language;
use App\Models\PayoutLog;
use App\Models\Template;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Define web root constant
        Config::set('filesystems.disks.public.root', public_path());
        
        // Define certificates path
        Config::set('app.certificates_path', storage_path('app/public/certificates'));
        Config::set('app.templates_path', storage_path('app/public/templates'));
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $data['basic'] = get_settings();
        $data['theme'] = template();
        $data['themeTrue'] = template(true);
        View::share($data);

        if (!file_exists(public_path('storage/uploads'))) {
            if (!file_exists(storage_path('uploads'))) {
                mkdir(storage_path('uploads'), 0777, true);
            }
            if (!file_exists(public_path('storage'))) {
                mkdir(public_path('storage'), 0777, true);
            }
            try {
                symlink(storage_path('uploads'), public_path('storage/uploads'));
            } catch (\Exception $e) {
                // Log the error but continue execution
                // On Windows, symlink creation may require administrator privileges
                // You may need to manually create this symlink or run the app with elevated privileges
            }
        }

        // Create necessary directories if they don't exist
        $paths = [
            storage_path('app/public/certificates'),
            storage_path('app/public/templates')
        ];

        foreach ($paths as $path) {
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
        }
    }
}
