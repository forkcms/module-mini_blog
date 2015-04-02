<?php

namespace Frontend\Modules\MiniBlog\Widgets;

/*
 * This is a widget with recent blogarticles
 *
 * @author Tijs Verkoyen <tijs@sumocoders.be>
 * @author Stef Bastiaansen <stef.bastiaansen@netlash.com>
 * @author Lander Vanderstraeten <lander.vanderstraeten@wijs.be>
 */

use Frontend\Core\Engine\Base\Widget as FrontendBaseWidget;
use Frontend\Modules\MiniBlog\Engine\Model as FrontendMiniBlogModel;

class RecentPosts extends FrontendBaseWidget
{
    /**
     * Execute the extra.
     */
    public function execute()
    {
        parent::execute();
        $this->loadTemplate();
        $this->parse();
    }

    /**
     * Parse.
     */
    private function parse()
    {
        $this->tpl->assign('widgetMiniBlogRecentPosts', FrontendMiniBlogModel::getAll(5));
    }
}
