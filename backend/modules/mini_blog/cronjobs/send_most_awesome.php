<?php

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

/**
 * This action will add a post to the blog module.
 *
 * @author Stef Bastiaansen <stef.bastiaansen@netlash.com>
 */
class BackendMiniBlogCronjobSendMostAwesome extends BackendBaseCronjob
{
	/**
	 * Execute the action
	 */
	public function execute()
	{
		$this->setBusyFile();

		$items = BackendMiniBlogModel::getTopAwesome();
		$str = '';

		foreach($items as $item)
		{
			$str .= '<p><a href="' . SITE_URL . $item['full_url'] . '">' . $item['title'] . ' (' . $item['awesomeness'] . ')</a></p>';
		}

		// variables to parse in the e-mail
		$variables['data'] = $str;

		// send e-mail to user
		BackendMailer::addEmail(ucfirst(BL::getMessage('AwesomenessTopFive')), BACKEND_MODULES_PATH . '/mini_blog/layout/templates/mails/send_top_awesome.tpl', $variables, BackendModel::getModuleSetting('core', 'admin_email', 'stef@netlash.com'));

		$this->clearBusyFile();
	}
}
