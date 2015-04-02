<?php
namespace Backend\Modules\MiniBlog\Cronjobs;

use Backend\Core\Engine\Base\Cronjob as BackendBaseCronjob;
use Backend\Modules\MiniBlog\Engine\Model as BackendMiniBlogModel;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Core\Engine\Language as BL;

/**
 * This cronjob sends an email containing the 5 top awesome blogposts.
 *
 * @author Lander Vanderstraeten <lander.vanderstraeten@wijs.be>
 */
class SendMostAwesome extends BackendBaseCronjob
{
    public function execute()
    {
        $this->setBusyFile();

        // get all Top awesome items
        $items = BackendMiniBlogModel::getTopAwesome();
        $str = '';
        // create a link for each item containing the title and #awesomeness
        foreach ((array) $items as $item) {
            $str .= '<p><a href="'.SITE_URL.$item['full_url'].'">'.
                $item['title'].' ('.$item['awesomeness'].')</a></p>';
        }
        $variables['data'] = $str;

        // build our message
        $to = BackendModel::getModuleSetting('Core', 'mailer_to');
        $from = BackendModel::getModuleSetting('Core', 'mailer_from');
        $replyTo = BackendModel::getModuleSetting('Core', 'mailer_reply_to');
        $tpl = BACKEND_MODULES_PATH.'/MiniBlog/Layout/Templates/Mails/Send_top_awesome.tpl';

        $message = \Common\Mailer\Message::newInstance(
            BL::msg('NotificationAwesomeness'))
            ->setFrom(array($from['email'] => $from['name']))
            ->setTo(array($to['email'] => $to['name']))
            ->setReplyTo(array($replyTo['email'] => $replyTo['name']))
            ->parseHtml(
                $tpl,
                $variables,
                true
            );
        $this->get('mailer')->send($message);

        $this->clearBusyFile();
    }
}
