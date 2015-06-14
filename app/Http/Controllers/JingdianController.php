<?php 
namespace App\Http\Controllers;
use Config, App\Customer, DB, Input, Log;
use Request,Auth;
class JingdianController extends Controller {

    public function __construct(){
        $this->role = Auth::user()->role;
        $this->arrRole = explode(',', $this->role);
    }

    //景点客户信息
    public function getJingdian($jingdian=1){
        if (!in_array('admin',$this->arrRole) && !in_array($jingdian, $this->arrRole)){
            exit('无权限');
        }
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
        $where['is_verify'] = 1;
        $where['is_refund'] = 0;
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
            'is_consume' => $is_consume,
            'name' => $name,
            'telephone' => $telephone,
            'customers' => $customers,
            'appends'   => $appends,
            'role'   => $this->role,
            'arrRole'   => $this->arrRole,
        ];
        return view('jingdian', $with);
        
    }
    //消费接口
    public function postConsumeCustomer($id){
        $res['status'] = 0;
        $res['info']   = '';
        $affectedRows = Customer::where('id', $id)->update(['is_consume' => 1]);
        if( ! $affectedRows) {
            $res['status'] = -1;
            $res['info'] = '消费失败';
        }
        echo json_encode($res);
    }
    //取消消费接口
    public function postUnconsumeCustomer($id){
        $res['status'] = 0;
        $res['info']   = '';
        $affectedRows = Customer::where('id', $id)->update(['is_consume' => 0]);
        if( ! $affectedRows) {
            $res['status'] = -1;
            $res['info'] = '取消消费失败';
        }
        echo json_encode($res);
    }
}
