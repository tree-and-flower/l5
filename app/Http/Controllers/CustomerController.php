<?php 
namespace App\Http\Controllers;
use Config, App\Customer, DB, Input, Log;
use Request;
use Auth;
use Excel;
class CustomerController extends Controller {

    public function __construct(){
        if('admin' != Auth::user()->role){
            exit('无权限');
        }
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
        $is_consume = Input::get('is_consume', -1);
        if (-1 != $is_consume) {
            $where['is_consume'] = $is_consume;
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
        $travel_at = Input::get('travel_at', '');
        $travel_at = trim($travel_at);
        if ('' != $travel_at) {
            $objBuiler = $objBuiler->where('travel_at', 'like',  "$travel_at%");
        }
        $created_at = Input::get('created_at', '');
        $created_at = trim($created_at);
        if ('' != $created_at) {
            $objBuiler = $objBuiler->where('created_at', 'like',  "$created_at%");
        }
        $name = Input::get('name', '');
        $name = trim($name);
        if ('' !== $name) {
            $objBuiler = $objBuiler->where('name', 'like',  "%$name%");
        }
        $telephone = Input::get('telephone', '');
        if ('' !== $telephone) {
            $objBuiler = $objBuiler->where('telephone', 'like',  "%$telephone%");
        }
        $orderBy = Input::get('orderBy', 'created_at desc');
        list($column, $order) = explode(' ', $orderBy);
        $jingdianConf = Config::get('tongxing.jingdian');
        $shangjiaConf = Config::get('tongxing.shangjia');
        $submitValue = Input::get('submit', '');
        $submitValue = trim($submitValue);
        if ('导出' == $submitValue) {
            set_time_limit(0);
            $customers = $objBuiler->orderBy($column, $order)->get();
            $excelName = $jingdianConf[$jingdian] . date('Y-m-d-H-i-s', time());
            $excelData = array();
            foreach ($customers as $k => $v) {
                $excelData[$k]['id'] = (int)$v->id;
                $excelData[$k]['是否验证'] = (1 == $v->is_verify) ? '已验证' : '未验证';
                $excelData[$k]['是否退款'] = (1 == $v->is_refund) ? '已退款' : '未退款';
                if (5 == $jingdian) {//刘老根需要消费
                    $excelData[$k]['是否消费'] = (1 == $v->is_resume) ? '已消费' : '未消费';
                }
                $excelData[$k]['商家'] = $shangjiaConf[((int)$v->shangjia)];
                $excelData[$k]['联系人'] = $v->name;
                $excelData[$k]['电话'] = $v->telephone;
                $excelData[$k]['出行日期'] = date('Y-m-d', strtotime($v->travel_at));
                $excelData[$k]['下单日期'] = $v->created_at->toDateTimeString();
                $excelData[$k]['身份证'] = trim($v->id_card);
                $excelData[$k]['团购券号'] = trim($v->ticket);
                $excelData[$k]['备注说明'] = trim($v->info);
            }
            Excel::create($excelName, function($excel) use($excelData){
                $excel->sheet('游客信息', function($sheet) use($excelData){
                    $sheet->fromArray($excelData, null, 'A1', true);
                });
            })->store('xls')->export('xls'); 
            return;
        }
        $customers = $objBuiler->orderBy($column, $order)->paginate(50);
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
            'is_consume' => $is_consume,
            'is_verify' => $is_verify,
            'is_refund' => $is_refund,
            'name' => $name,
            'travel_at' => $travel_at,
            'created_at' => $created_at,
            'telephone' => $telephone,
            'customers' => $customers,
            'appends'   => $appends,
        ];
        return view('customer-jingdian', $with);
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
        $id_card = trim($data['id_card']); 
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
                'id_card' => $id_card,
                'ticket' => $ticket,
                'info' => $info,
        ]; 
        Customer::where('id', $id)->update($customer);
        echo json_encode($res);
    }
}
