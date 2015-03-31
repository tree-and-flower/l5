<?php 
namespace APP\Http\Controllers;
use Overtrue\Wechat\Services\Message;

class WechatController extends Controller {

    /*
     * 处理微信的请求信息
     *
     * @return string
     */
    public function serve(){
        \Wechat::on('message', function($message){
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
            if($message->MsgType == 'text'){
                return Message::make('text')->content($message->Content);
            }else if ($message->MsgType == 'voice'){
                return Message::make('text')->content('voice' . $message->MediaId);
                //return Message::make('voice')->media($message->MediaId);
            }
            //\Log::info("receive from {$message['FromUserName']}:{$message['Content']}");
        });
        return \Wechat::serve();
    }
}
