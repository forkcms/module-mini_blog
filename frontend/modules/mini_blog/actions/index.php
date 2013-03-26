<?php

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

/**
 * This is the overview-action
 *
 * @author Tijs Verkoyen <tijs@sumocoders.be>
 * @author Davy Hellemans <davy.hellemans@netlash.com>
 */
class FrontendMiniBlogIndex extends FrontendBaseBlock
{
	/**
	 * The articles
	 *
	 * @var	array
	 */
	private $items;

	/**
	 * The pagination array
	 * It will hold all needed parameters, some of them need initialization.
	 *
	 * @var	array
	 */
	protected $pagination = array(
		'limit' => 10,
		'offset' => 0,
		'requested_page' => 1,
		'num_items' => null,
		'num_pages' => null
	);

	/**
	 * Execute the extra
	 */
	public function execute()
	{
		parent::execute();
		$this->loadTemplate();
		$this->getData();
		$this->parse();
	}

	/**
	 * Load the data, don't forget to validate the incoming data
	 */
	private function getData()
	{
		// requested page
		$requestedPage = $this->URL->getParameter('page', 'int', 1);

		$this->pagination['url'] = FrontendNavigation::getURLForBlock('mini_blog');
		$this->pagination['limit'] = FrontendModel::getModuleSetting('mini_blog', 'overview_num_items', 10);
		$this->pagination['num_items'] = FrontendMiniBlogModel::getAllCount();
		$this->pagination['num_pages'] = (int) ceil($this->pagination['num_items'] / $this->pagination['limit']);
		$this->pagination['requested_page'] = $requestedPage;
		$this->pagination['offset'] = ($this->pagination['requested_page'] * $this->pagination['limit']) - $this->pagination['limit'];

		if($this->pagination['num_pages'] == 0) $this->pagination['num_pages'] = 1;
		if($requestedPage > $this->pagination['num_pages'] || $requestedPage < 1) $this->redirect(FrontendNavigation::getURL(404));

		$this->items = FrontendMiniBlogModel::getAll($this->pagination['limit'], $this->pagination['offset']);
	}

	/**
	 * Parse the data into the template
	 */
	protected function parse()
	{
		$this->tpl->assign('items', $this->items);
		$this->parsePagination();
	}
}
