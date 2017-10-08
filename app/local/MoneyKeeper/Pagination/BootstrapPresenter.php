<?php
namespace MoneyKeeper\Pagination;

/**
 *  Custom pagination presenter
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class BootstrapPresenter extends \Illuminate\Pagination\Presenter {

	/**
	 * Get HTML wrapper for a page link.
	 *
	 * @param  string  $url
	 * @param  int  $page
	 * @param  string  $rel
	 * @return string
	 */
	public function getPageLinkWrapper($url, $page, $rel = null)
	{
		$rel = is_null($rel) ? '' : ' rel="'.$rel.'"';

		return '<li class="page-item"><a class="page-link" href="'.$url.'"'.$rel.'>'.$page.'</a></li>';
	}

	/**
	 * Get HTML wrapper for disabled text.
	 *
	 * @param  string  $text
	 * @return string
	 */
	public function getDisabledTextWrapper($text)
	{
		return '<li class="page-item disabled"><span class="page-link">'.$text.'</span></li>';
	}

	/**
	 * Get HTML wrapper for active text.
	 *
	 * @param  string  $text
	 * @return string
	 */
	public function getActivePageWrapper($text)
	{
		return '<li class="page-item active"><span class="page-link">'.$text.'</span></li>';
	}
    
    /**
	 * Create a pagination slider link window.
	 *
	 * @return string
	 */
	protected function getPageSlider()
	{
		$window = 3;

		// If the current page is very close to the beginning of the page range, we will
		// just render the beginning of the page range, followed by the last 2 of the
		// links in this list, since we will not have room to create a full slider.
		if ($this->currentPage <= $window)
		{
			$ending = $this->getFinish();

			return $this->getPageRange(1, $window + 2).$ending;
		}

		// If the current page is close to the ending of the page range we will just get
		// this first couple pages, followed by a larger window of these ending pages
		// since we're too close to the end of the list to create a full on slider.
		elseif ($this->currentPage >= $this->lastPage - $window)
		{
			$start = $this->lastPage - 5;

			$content = $this->getPageRange($start, $this->lastPage);

			return $this->getStart().$content;
		}

		// If we have enough room on both sides of the current page to build a slider we
		// will surround it with both the beginning and ending caps, with this window
		// of pages in the middle providing a Google style sliding paginator setup.
		else
		{
			$content = $this->getAdjacentRange();

			return $this->getStart().$content.$this->getFinish();
		}
	}
    
    /**
	 * Get the page range for the current page window.
	 *
	 * @return string
	 */
	public function getAdjacentRange()
	{
		return $this->getPageRange($this->currentPage - 2, $this->currentPage + 2);
	}
    
    /**
	 * Create the beginning leader of a pagination slider.
	 *
	 * @return string
	 */
	public function getStart()
	{
		return $this->getPageRange(1, 1).$this->getDots();
	}

	/**
	 * Create the ending cap of a pagination slider.
	 *
	 * @return string
	 */
	public function getFinish()
	{
		$content = $this->getPageRange($this->lastPage, $this->lastPage);

		return $this->getDots().$content;
	}

}
