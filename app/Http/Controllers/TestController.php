<?php 
namespace App\Http\Controllers;
use Config, App\Customer, DB, Input, Log,Request;
use Excel;
class TestController extends Controller {

    public function index(){
    $travel_at = Request::input('date',date('Y-m-d',strtotime('+1 day')));
    $res = Customer::where('travel_at', $travel_at)->where('jingdian', 1)->where('is_verify', 1)->where('telephone', '!=','17727822012')->where('telephone','!=','13422872077')->get();
    $arrTicket = [];
    foreach($res as $k => $v){
        $strTicket = str_replace(['，','。','.','、'],',',$v['ticket']);
        $strTicket = str_replace([' ',"\n"],'',$strTicket);
        $arrTicket = array_merge(explode(',',$strTicket),$arrTicket);
        $arrTicket = array_filter($arrTicket);
    }
    echo '<pre>';
    echo '该日期出行总人数约为:'.count($arrTicket).'<br>';
    print_r($arrTicket);    
        /*
        $user = [
            'name'     => '海洋世界',
            'email'    => 'llg@tongxing.com',    
            'password' => bcrypt('llg123'),
            'role'     => '4,5,6,7,8,9,10,11,12',
        ];
        User::create($user);
        */
        //var_dump(Agent::is('OS X'));
    }

    public function getBook($jingdian=0,$shangjia=0){
        $jingdianConf = Config::get('tongxing.jingdian');
        $shangjiaConf = Config::get('tongxing.shangjia');
        return view('book-new', ['jingdianConf' => $jingdianConf, 'shangjiaConf' => $shangjiaConf, 'jingdian' => $jingdian, 'shangjia' => $shangjia]);
    }
    public function postBook(){
        $res['status'] = 0;
        $res['info']   = '';
        $data = Input::all();
        $jingdian = $data['jingdian'];
        $shangjia = $data['shangjia'];
        $travel_at = $data['travel_at'];
        $name = trim($data['name']); 
        if($name == ''){
            $res['status'] = 1;
            $res['info'] = '主要联系人姓名不能为空';
        }
        $telephone = trim($data['telephone']); 
        $ticket = trim($data['ticket']); 
        if($ticket == ''){
            $res['status'] = 1;
            $res['info'] = '团购券号不能为空';
        }
        $info = trim($data['info']);
        $customer = [
                'jingdian' => $jingdian,
                'shangjia' => $shangjia,
                'travel_at' => $travel_at,
                'name' => $name,
                'telephone' => $telephone,
                'ticket' => $ticket,
                'info' => $info,
        ]; 
        Customer::create($customer);
        echo json_encode($res);
    }
}
