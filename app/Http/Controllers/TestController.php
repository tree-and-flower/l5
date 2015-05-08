<?php 
namespace App\Http\Controllers;
use Config, App\Customer, DB, Input, Log;
use Agent;
class TestController extends Controller {

    public function index(){
        var_dump(Agent::is('OS X'));
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
