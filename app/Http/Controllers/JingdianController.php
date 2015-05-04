<?php 
namespace App\Http\Controllers;
use Config, App\Customer, DB, Input, Log;
class JingdianController extends Controller {

    public function __construct(){
        //DB::connection()->enableQueryLog();
    }

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
        $customers = $objBuiler->orderBy($column, $order)->get();
        $jingdianConf = Config::get('tongxing.jingdian');
        $shangjiaConf = Config::get('tongxing.shangjia');
        $with = [
            'jingdianConf' => $jingdianConf, 
            'shangjiaConf' => $shangjiaConf, 
            'jingdian' => $jingdian, 
            'shangjia' => $shangjia,
            'is_verify' => $is_verify,
            'name' => $name,
            'telephone' => $telephone,
            'customers' => $customers,
        ];
        /*
        $queries = DB::getQueryLog();
        echo '<pre>';print_r($queries);exit;
         */
        return view('jingdian', $with);
        
    }

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
}
