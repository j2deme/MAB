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
