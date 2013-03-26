<?php

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

/**
 * This is the detail-action
 *
 * @author Tijs Verkoyen <tijs@sumocoders.be>
 * @author Davy Hellemans <davy.hellemans@netlash.com>
 * @author Dieter Vanden Eynde <dieter.vandeneynde@netlash.com>
 * @author Stef Bastiaansen <stef.bastiaansen@netlash.com>
 * @author Jelmer Snoeck <jelmer.snoeck@netlash.com>
 */
class FrontendMiniBlogDetail extends FrontendBaseBlock
{
	/**
	 * The blogpost
	 *
	 * @var	array
	 */
	private $record;

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
		if($this->URL->getParameter(1) === null) $this->redirect(FrontendNavigation::getURL(404));

		// get by URL
		$this->record = FrontendMiniBlogModel::get($this->URL->getParameter(1));
		if(empty($this->record)) $this->redirect(FrontendNavigation::getURL(404));

		$this->record['full_url'] = FrontendNavigation::getURLForBlock('mini_blog', 'detail') . '/' . $this->record['url'];
		$this->record['tags'] = FrontendTagsModel::getForItem('mini_blog', $this->record['id']);
	}

	/**
	 * Parse the data into the template
	 */
	private function parse()
	{
		$this->breadcrumb->addElement($this->record['title']);

		// set meta
		$this->header->setPageTitle($this->record['title']);
		$this->header->addMetaDescription($this->record['meta_description'], ($this->record['meta_description_overwrite'] == 'Y'));
		$this->header->addMetaKeywords($this->record['meta_keywords'], ($this->record['meta_keywords_overwrite'] == 'Y'));

		$this->tpl->assign('hideContentTitle', true);
		$this->tpl->assign('item', $this->record);

		$navigation = FrontendMiniBlogModel::getNavigation($this->record['id']);
		if($navigation['previous'] === null && $navigation['next'] === null) $navigation = false;
		$this->tpl->assign('navigation', $navigation);
	}
}
