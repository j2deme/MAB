<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    Blade::directive('auth', function () {
      return "<?php if(Auth::check()) {?>";
    });

    Blade::directive('guest', function () {
      return "<?php } else { ?>";
    });

    Blade::directive('endauth', function () {
      return "<?php } ?>";
    });

    Blade::directive('method', function ($expression) {
      return "<?php echo method_field{$expression}; ?>";
    });

    Blade::directive('csrf', function () {
      return "<?php echo csrf_field(); ?>";
    });
  }

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }
}
