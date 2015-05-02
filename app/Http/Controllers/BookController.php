<?php 
namespace APP\Http\Controllers;
use Config;
use Input;
use Log;
class BookController extends Controller {

    public function getBook($jingdian=0,$shangjia=0){
        $jingdianConf = Config::get('tongxing.jingdian');
        $shangjiaConf = Config::get('tongxing.shangjia');
        return view('book', ['jingdianConf' => $jingdianConf, 'shangjiaConf' => $shangjiaConf, 'jingdian' => $jingdian, 'shangjia' => $shangjia]);
    }
    public function postBook(){
        echo '<pre>';
        print_r(Input::all());
    }
}
