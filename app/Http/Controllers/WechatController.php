<?php 
namespace APP\Http\Controllers;
use Overtrue\Wechat\Services\Message;
use Config;
use Log;
class WechatController extends Controller {
    const TEXT_SUBSCRIBE = <<<END
欢迎关注深圳[同行旅游]景点门票O2O服务号。输入景点名，即可查询该景点门票价格、开放时间等详细信息。如海洋世界、世界之窗、欢乐谷、锦绣中华民俗村等。
END;
    const TEXT_DEFAULT = <<<END
请输入景点名，即可查询该景点门票价格、开放时间等详细信息。如海洋世界、世界之窗、欢乐谷、锦绣中华民俗村等。
END;
    const TEXT_TICKET_BOOK = <<<END
输入景点名（如世界之窗）查询门票价格、开放时间等详细信息。门票预定接受两种预定方式，预定时间截止到出行时间的前天晚上12点。
预定方式1：
直接回复预定信息：[姓名][联系方式][景点名称][预定人数]
例：张三，18828282828，世界之窗，3人
预定方式2：
通过以下联系进行预定：
QQ:306824269
TEL:13422872077
END;
    const TEXT_USE_INFO = <<<END
请输入景点名，即可查询该景点门票价格、开放时间等详细信息。
如海洋世界、世界之窗、欢乐谷、锦绣中华民俗村等，预订、退订请仔细阅读说明。
END;
    const TEXT_TICKET_UNBOOK = <<<END
已经预订的用户直接通过以下联系方式取消预订，截止时间为出行时间的前天晚上12点。
QQ:306824269
TEL:13422872077
END;
    const TEXT_O2O = <<<END
线上到线下模式的一种实际场景，专注于提供目的地景点门票预订的极致用户体验。
END;
    public function __construct(){
        $this->wc = \App::make('wechat');
    }

    /*
     * 处理微信的请求信息
     *
     * @return string
     */
    public function serve(){
        $keyword = Config::get('keyword');
        //订阅事件消息回复
        $this->wc->event('subscribe', function ($event){
            return Message::make('text')->content(self::TEXT_SUBSCRIBE);
        });
        //普通消息只有文本类型时进行模糊匹配
        $this->wc->message(function($msg) use ($keyword) {
            if ('text' == $msg->MsgType) {
                foreach ($keyword as $word => $content) {
                    if (false !== strpos($msg->Content, $word)) {
                        return Message::make('text')->content($content);
                    }
                }
            }
            return Message::make('text')->content(self::TEXT_DEFAULT);
            //Log::info("info",[info => 'info']);
        });
        $this->wc->event(function ($event){
                if($event->EventKey == 'CLICK_TICKET_BOOK'){
                    return Message::make('text')->content(self::TEXT_TICKET_BOOK);
                }
                if($event->EventKey == 'CLICK_USE_INFO'){
                    return Message::make('text')->content(self::TEXT_USE_INFO);
                }
                if($event->EventKey == 'CLICK_TICKET_UNBOOK'){
                    return Message::make('text')->content(self::TEXT_TICKET_UNBOOK);
                }
                if($event->EventKey == 'CLICK_O2O'){
                    return Message::make('text')->content(self::TEXT_O2O);
                }
        });
        return $this->wc->serve();
    }

    /**
     * 设置菜单
     */
    public function setMenu(){
        $objMenu = $this->wc->menu;
        $menus = array(
            $objMenu->make('景点介绍')->buttons(array(
                $objMenu->make('海洋世界', 'view', 'http://baike.baidu.com/item/%E6%B7%B1%E5%9C%B3%E6%B5%B7%E6%B4%8B%E4%B8%96%E7%95%8C'),
                $objMenu->make('世界之窗', 'view', 'http://baike.baidu.com/subview/15797/5589060.htm#viewPageContent'),
                $objMenu->make('欢乐谷', 'view', 'http://baike.baidu.com/item/%E6%B7%B1%E5%9C%B3%E6%AC%A2%E4%B9%90%E8%B0%B7'),
            )),
            $objMenu->make('门票预订', 'click', 'CLICK_TICKET_BOOK'),
            $objMenu->make('自助服务')->buttons(array(
                $objMenu->make('使用说明', 'click', 'CLICK_USE_INFO'),
                $objMenu->make('退订说明', 'click', 'CLICK_TICKET_UNBOOK'),
                $objMenu->make('门票O2O', 'click', 'CLICK_O2O'),
            )),
        );

        try {
            $objMenu->set($menus);
            echo '设置成功！';
        } catch (\Exception $e) {
            echo '设置失败：' . $e->getMessage();
        }
    }
}
