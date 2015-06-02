<?php 
namespace App\Http\Controllers;
use Config, App\Customer, DB, Input, Log;
use Request;
class CustomerController extends Controller {

    public function __construct(){
        $this->middleware('auth');
        //DB::connection()->enableQueryLog();
    }

    //景点客户信息
    public function getJingdian($jingdian=1){
        $where = [];
        $where['jingdian'] = $jingdian;
        $shangjia = Input::get('shangjia', 0);
        if ($shangjia) {
            $where['shangjia'] = $shangjia;
        }
        $is_verify = Input::get('is_verify', -1);
        if (-1 != $is_verify) {
            $where['is_verify'] = $is_verify;
        }
        $is_refund = Input::get('is_refund', -1);
        if (-1 != $is_refund) {
            $where['is_refund'] = $is_refund;
        }
        $where['is_del'] = 0;
        $objBuiler = Customer::where($where);
        $name = Input::get('name', '');
        if ('' !== $name) {
            $objBuiler = $objBuiler->where('name', 'like',  "%$name%");
        }
        $telephone = Input::get('telephone', '');
        if ('' !== $telephone) {
            $objBuiler = $objBuiler->where('telephone', 'like',  "%$telephone%");
        }
        $orderBy = Input::get('orderBy', 'created_at desc');
        list($column, $order) = explode(' ', $orderBy);
        $customers = $objBuiler->orderBy($column, $order)->paginate(50);
        $jingdianConf = Config::get('tongxing.jingdian');
        $shangjiaConf = Config::get('tongxing.shangjia');
        //分页查询字符串
        $request_uri = $_SERVER['REQUEST_URI'];
        $info = parse_url($request_uri);
        $appends = Request::all();
        unset($appends['page']);
        $with = [
            'jingdianConf' => $jingdianConf, 
            'shangjiaConf' => $shangjiaConf, 
            'jingdian' => $jingdian, 
            'shangjia' => $shangjia,
            'is_verify' => $is_verify,
            'is_refund' => $is_refund,
            'name' => $name,
            'telephone' => $telephone,
            'customers' => $customers,
            'appends'   => $appends,
        ];
        /*
        $queries = DB::getQueryLog();
        echo '<pre>';print_r($queries);exit;
         */
        return view('jingdian', $with);
        
    }
    //删除接口
    public function postDelCustomer($id){
        $res['status'] = 0;
        $res['info']   = '';
        $affectedRows = Customer::where('id', $id)->update(['is_del' => 1]);
        if( ! $affectedRows) {
            $res['status'] = -1;
            $res['info'] = '删除失败';
        }
        echo json_encode($res);
    }
    //验证接口
    public function postVerifyCustomer($id){
        $res['status'] = 0;
        $res['info']   = '';
        $affectedRows = Customer::where('id', $id)->update(['is_verify' => 1]);
        if( ! $affectedRows) {
            $res['status'] = -1;
            $res['info'] = '验证失败';
        }
        echo json_encode($res);
    }
    //取消验证接口
    public function postUnverifyCustomer($id){
        $res['status'] = 0;
        $res['info']   = '';
        $affectedRows = Customer::where('id', $id)->update(['is_verify' => 0]);
        if( ! $affectedRows) {
            $res['status'] = -1;
            $res['info'] = '取消验证失败';
        }
        echo json_encode($res);
    }
    //退款接口
    public function postRefundCustomer($id){
        $res['status'] = 0;
        $res['info']   = '';
        $affectedRows = Customer::where('id', $id)->update(['is_refund' => 1]);
        if( ! $affectedRows) {
            $res['status'] = -1;
            $res['info'] = '验证失败';
        }
        echo json_encode($res);
    }
    //取消退款接口
    public function postUnrefundCustomer($id){
        $res['status'] = 0;
        $res['info']   = '';
        $affectedRows = Customer::where('id', $id)->update(['is_refund' => 0]);
        if( ! $affectedRows) {
            $res['status'] = -1;
            $res['info'] = '取消验证失败';
        }
        echo json_encode($res);
    }
    //客户编辑
    public function getEdit($id){
        $id = intval($id);
        if($id <= 0){
            exit('客户ID不正确');
        }
        $jingdianConf = Config::get('tongxing.jingdian');
        $shangjiaConf = Config::get('tongxing.shangjia');
        $customer = Customer::where('id', $id)->get();
        if (count($customer) > 0) {
            $customer = $customer[0];
        } else {
            exit('客户ID不正确');
        }
        $with = [
            'jingdianConf' => $jingdianConf, 
            'shangjiaConf' => $shangjiaConf, 
            'customer'     => $customer,
        ];
        return view('editCustomer', $with);
        
    }
    public function postEdit(){
        $res['status'] = 0;
        $res['info']   = '';
        $data = Input::all();
        $id       = $data['id'];
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
        Customer::where('id', $id)->update($customer);
        echo json_encode($res);
    }
}
