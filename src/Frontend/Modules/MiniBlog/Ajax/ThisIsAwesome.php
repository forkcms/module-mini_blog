<?php
namespace Frontend\Modules\MiniBlog\Ajax;

use Frontend\Core\Engine\Base\AjaxAction as FrontendBaseAJAXAction;
use Frontend\Modules\MiniBlog\Engine\Model as FrontendMiniBlogModel;

/**
 * ThisIsAwesome
 * @author Lander Vanderstraeten <lander.vanderstraeten@wijs.be>
 */
class ThisIsAwesome extends FrontendBaseAJAXAction
{
    public function execute()
    {
        $post_id = (int)\SpoonFilter::getPostValue('post_id', null, '', 'int');

        if ($post_id == 0) {
            $this->output(self::BAD_REQUEST, null, 'invalid post_id-parameter.');
        }

        FrontendMiniBlogModel::addAwesomeness($post_id);

        $this->output(self::OK);
    }
}