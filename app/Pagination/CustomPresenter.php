<?php

namespace App\Pagination;

use Illuminate\Support\HtmlString;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Pagination\UrlWindowPresenterTrait;
use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;
use Illuminate\Contracts\Pagination\Presenter as PresenterContract;
use Illuminate\Pagination\BootstrapThreeNextPreviousButtonRendererTrait;

class CustomPresenter implements PresenterContract
{
  use BootstrapThreeNextPreviousButtonRendererTrait, UrlWindowPresenterTrait;

  /**
   * The paginator implementation.
   *
   * @var \Illuminate\Contracts\Pagination\Paginator
   */
  protected $paginator;

  /**
   * The URL window data structure.
   *
   * @var array
   */
  protected $window;

  /**
   * Create a new Bootstrap presenter instance.
   *
   * @param  \Illuminate\Contracts\Pagination\Paginator  $paginator
   * @param  \Illuminate\Pagination\UrlWindow|null  $window
   * @return void
   */
  public function __construct(PaginatorContract $paginator, UrlWindow $window = null)
  {
    $this->paginator = $paginator;
    $this->window = is_null($window) ? UrlWindow::make($paginator) : $window->get();
  }

  /**
   * Determine if the underlying paginator being presented has pages to show.
   *
   * @return bool
   */
  public function hasPages()
  {
    return $this->paginator->hasPages();
  }

  /**
   * Convert the URL window into Bootstrap HTML.
   *
   * @return \Illuminate\Support\HtmlString
   */
  public function render()
  {
    if ($this->hasPages()) {
      return new HtmlString(sprintf(
        '<div class="ui left floated pagination menu">%s %s %s</div>',
        $this->getPreviousButton('<i class="left chevron icon"></i>'),
        $this->getLinks(),
        $this->getNextButton('<i class="right chevron icon"></i>')
      ));
    }

    return '';
  }

  /**
   * Get HTML wrapper for an available page link.
   *
   * @param  string  $url
   * @param  int  $page
   * @param  string|null  $rel
   * @return string
   */
  protected function getAvailablePageWrapper($url, $page, $rel = null)
  {
    $rel = is_null($rel) ? '' : ' rel="' . $rel . '"';

    return '<a href="' . htmlentities($url) . '"' . $rel . ' class="icon item">' . $page . '</a>';
  }

  /**
   * Get HTML wrapper for disabled text.
   *
   * @param  string  $text
   * @return string
   */
  protected function getDisabledTextWrapper($text)
  {
    return '<a class="disabled item"><span>' . $text . '</span></a>';
  }

  /**
   * Get HTML wrapper for active text.
   *
   * @param  string  $text
   * @return string
   */
  protected function getActivePageWrapper($text)
  {
    return '<a class="active icon item"><span>' . $text . '</span></a>';
  }

  /**
   * Get a pagination "dot" element.
   *
   * @return string
   */
  protected function getDots()
  {
    return $this->getDisabledTextWrapper('...');
  }

  /**
   * Get the current page from the paginator.
   *
   * @return int
   */
  protected function currentPage()
  {
    return $this->paginator->currentPage();
  }

  /**
   * Get the last page from the paginator.
   *
   * @return int
   */
  protected function lastPage()
  {
    return $this->paginator->lastPage();
  }
}
