<?php

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

/**
 * This action will load a form with the item data and save the chagnes.
 *
 * @author Dave Lens <dave.lens@netlash.com>
 * @author Davy Hellemans <davy.hellemans@netlash.com>
 * @author Stef Bastiaansen <stef.bastiaansen@netlash.com>
 */
class BackendMiniBlogEdit extends BackendBaseActionEdit
{
	/**
	 * Execute the action
	 */
	public function execute()
	{
		$this->id = $this->getParameter('id', 'int');

		// does the item exists
		if($this->id !== null && BackendMiniBlogModel::exists($this->id))
		{
			parent::execute();
			$this->getData();

			$this->loadForm();
			$this->validateForm();

			$this->parse();
			$this->display();
		}
		else $this->redirect(BackendModel::createURLForAction('index') . '&error=non-existing');
	}

	/**
	 * Get the data
	 */
	private function getData()
	{
		$this->record = (array) BackendMiniBlogModel::get($this->id);

		// no item found, redirect to index
		if(empty($this->record)) $this->redirect(BackendModel::createURLForAction('index') . '&error=non-existing');
	}

	/**
	 * Load the form
	 */
	private function loadForm()
	{
		$this->frm = new BackendForm('edit');
		$this->frm->addText('title', $this->record['title'], 255, 'inputText title', 'inputTextError title');
		$this->frm->addEditor('text', $this->record['text']);
		$this->frm->addEditor('introduction', $this->record['introduction']);
		$this->frm->addCheckbox('publish', ($this->record['publish'] === 'Y' ? true : false));
		$this->frm->addText('tags', BackendTagsModel::getTags($this->URL->getModule(), $this->record['id']), null, 'inputText tagBox', 'inputTextError tagBox');

		$this->meta = new BackendMeta($this->frm, $this->record['meta_id'], 'title', true);
		$this->meta->setUrlCallback('BackendBlogModel', 'getURL', array($this->record['id']));
	}

	/**
	 * Parse the form
	 */
	protected function parse()
	{
		parent::parse();

		// assign this variable so it can be used in the template
		$this->tpl->assign('item', $this->record);
		$this->tpl->assign('detailURL', SITE_URL . BackendModel::getURLForBlock($this->URL->getModule(), 'detail') . '/' . $this->record['url']);
	}

	/**
	 * Validate the form
	 */
	private function validateForm()
	{
		if($this->frm->isSubmitted())
		{
			$this->frm->cleanupFields();

			// validation
			$this->frm->getField('title')->isFilled(BL::err('TitleIsRequired'));
			$this->frm->getField('introduction')->isFilled(BL::err('FieldIsRequired'));
			$this->frm->getField('text')->isFilled(BL::err('FieldIsRequired'));
			$this->meta->validate();

			if($this->frm->isCorrect())
			{
				$item['id'] = $this->record['id'];
				$item['meta_id'] = $this->meta->save();
				$item['language'] = BL::getWorkingLanguage();
				$item['title'] = $this->frm->getField('title')->getValue();
				$item['introduction'] = $this->frm->getField('introduction')->getValue();
				$item['text'] = $this->frm->getField('text')->getValue();
				$item['publish'] = $this->frm->getField('publish')->getChecked() ? 'Y' : 'N';
				$item['user_id'] = BackendAuthentication::getUser()->getUserId();
				$item['edited'] = date('Y-m-d H:i:s');

				BackendMiniBlogModel::update($item);

				// save the tags
				BackendTagsModel::saveTags($item['id'], $this->frm->getField('tags')->getValue(), $this->URL->getModule());

				// edit searchindex
				BackendSearchModel::saveIndex('mini_blog', $item['id'], array('title' => $item['title'], 'introduction' => $item['introduction'], 'text' => $item['text']));

				// trigger an event
				BackendModel::triggerEvent('mini_blog', 'after_edit', $item);

				// everything is saved, so redirect to the overview
				$this->redirect(BackendModel::createURLForAction('index') . '&report=added&var=' . urlencode($item['title']) . '&highlight=row-' . $item['id']);
			}
		}
	}
}
