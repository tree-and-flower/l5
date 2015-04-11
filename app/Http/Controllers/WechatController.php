<?php 
namespace APP\Http\Controllers;
use Overtrue\Wechat\Services\Message;
use Overtrue\Wechat\Services\Menu;

class WechatController extends Controller {

    public function __construct(){
        $this->wc = \App::make('wechat');
    }

    /*
     * 处理微信的请求信息
     *
     * @return string
     */
    public function serve(){
        $this->wc->message('image', function($message){
            /*
            return  Message::make('news')->items(function(){
                return array(
                    Message::make('news_item')->title('测试标题'),
                    Message::make('news_item')->title('测试标题2')->description('好不好？'),
                    Message::make('news_item')->title('测试标题3')->description('好不好说句话？')->url('http://baidu.com'),
                    Message::make('news_item')->title('测试标题4')->url('http://baidu.com/abc.php')->picUrl('http://www.baidu.com/demo.jpg'),
                );
            });
             */
                return Message::make('text')->content($message->PicUrl);
                //return Message::make('voice')->media($message->MediaId);
            //\Log::info("receive from {$message['FromUserName']}:{$message['Content']}");
        });
        $this->wc->event(function ($event){
                return Message::make('text')->content(serialize($event));
        });
        return $this->wc->serve();
    }

    /**
     * 设置菜单
     */
    public function setMenu(){
        $menus = array(
            Menu::make("门票")->buttons(array(
                Menu::view('海洋世界', 'http://www.meituan.com/deal/28664106.html'),
                Menu::view('世界之窗', 'http://www.meituan.com/deal/28664106.html'),
            )),
            Menu::make("线路")->buttons(array(
                Menu::view('欧洲游', 'http://bjsz4.package.qunar.com/user/detail.jsp?id=2039777643#tf=%E5%8C%97%E4%BA%AC%5F%E6%99%AE%E5%90%89%E5%B2%9B%5F149'),
                Menu::view('新马泰路线', 'http://bjsz4.package.qunar.com/user/detail.jsp?id=2039777643#tf=%E5%8C%97%E4%BA%AC%5F%E6%99%AE%E5%90%89%E5%B2%9B%5F149'),
            )),
            Menu::make("服务")->buttons(array(
                Menu::click('在线咨询', 'V1001_GOOD'),
                Menu::view('公司简介', 'http://wd.koudai.com/?userid=213348970'),
                Menu::view('门票O2O模式', 'http://www.netjun.com/tag/%E9%97%A8%E7%A5%A8'),
            )),
        );

        try {
            $objMenu = new Menu();
            $objMenu->set($menus);// 请求微信服务器
            echo '设置成功！';
        } catch (\Exception $e) {
            echo '设置失败：' . $e->getMessage();
        }
    }
}
