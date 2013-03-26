<?php

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

/**
 * This is a widget with recent blogarticles
 *
 * @author Tijs Verkoyen <tijs@sumocoders.be>
 * @author Stef Bastiaansen <stef.bastiaansen@netlash.com>
 */
class FrontendMiniBlogWidgetRecentPosts extends FrontendBaseWidget
{
	/**
	 * Execute the extra
	 */
	public function execute()
	{
		parent::execute();
		$this->loadTemplate();
		$this->parse();
	}

	/**
	 * Parse
	 */
	private function parse()
	{
		$this->tpl->assign('widgetMiniBlogRecentPosts', FrontendMiniBlogModel::getAll(5));
	}
}
