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
      return "<?php if(Auth::check()) { ?>";
    });

    Blade::directive('orguest', function () {
      return "<?php } else { ?>";
    });

    Blade::directive('guest', function () {
      return "<?php if(!Auth::check()) { ?>";
    });

    Blade::directive('hasError', function () {
      return '<?php echo ($errors->isEmpty()) ? null : \'error\'; ?>';
    });

    Blade::directive('error', function ($input) {
      return '<?php if($errors->has' . $input . ') { ?>';
    });

    Blade::directive('end', function () {
      return "<?php } ?>";
    });

    Blade::directive('method', function ($method) {
      return "<?php echo method_field{$method}; ?>";
    });

    Blade::directive('csrf', function () {
      return "<?php echo csrf_field(); ?>";
    });

    Blade::directive('js', function ($js) {
      $js = str_replace(['(', ')', ' '], '', $js); # Strips ( and )
      return "<script src='{{asset(\"js/$js\")}}'></script>";
    });

    Blade::directive('css', function ($css) {
      $css = str_replace(['(', ')', ' '], '', $css); # Strips ( and )
      return "<link  href='{{asset(\"css/$css\")}}' rel='stylesheet'>";
    });

    Blade::directive('dd', function ($value) {
      if (config('app.debug')) {
        return "<?php dump{$value}; ?>";
      }
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
