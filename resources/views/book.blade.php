@extends('framework')

@section('content')
<div class="container">
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="book-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">欢迎使用同行网预约系统</h3>
            </div>
            <div class="panel-body">
                <form role="form" method="POST">
                    <fieldset>
                        <div class="form-group">
                            <label class="control-label">景点名称</label>
                            <select class="form-control" name="jingdian" id="jingdian">
                            @foreach ($jingdianConf as $k => $v)
                            <option value="{{$k}}" @if($k == $jingdian)selected @endif>{{$v}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">商家名称</label>
                            <select class="form-control" name="shangjia" id="shangjia">
                            @foreach ($shangjiaConf as $k => $v)
                            <option value="{{$k}}" @if($k == $shangjia)selected @endif>{{$v}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">出行日期</label>
                            <input class="form-control" placeholder="点击选择出行日期" style="background-color:#FFF" name="travel_at" id="travel_at" type="text" readonly="readonly" >
                        </div>
                        <div class="form-group">
                            <label class="control-label">主要联系人</label>
                            <input class="form-control" placeholder="请输入主要联系人姓名" name="name" id="name" type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label">手机</label>
                            <input class="form-control" placeholder="请输入主要联系人手机" name="telephone" id="telephone" type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label">团购券号(多个券号以逗号，分隔)</label>
                            <textarea class="form-control" rows="3" name="ticket" id="ticket"  placeholder="多个券号以逗号分隔"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label">备注(可填写人数信息)</label>
                            <textarea class="form-control" rows="2" name="info" id="info" placeholder="备注信息"></textarea>
                        </div>
                        <button type="button" id="book"  class="btn btn-lg btn-warning btn-block">立即预约</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('js')
<script type="text/javascript" src="/js/laydate.js"></script>
<script type="text/javascript">
!function(){
    laydate.skin('molv');//切换皮肤，请查看skins下面皮肤库
    laydate({
        elem: '#travel_at',
            festival: true, //显示节日
            min: laydate.now(+1), 
    });
}();

</script>
<script>
$(document).ready(function(){
    $('#book').click(function(){
        var data = {};
        data['jingdian'] = $("#jingdian").val();
        data['shangjia'] = $("#shangjia").val();
        data['travel_at'] = $("#travel_at").val();
        if(data['travel_at'] == ''){
            alert('出发日期必填');
            return false;
        }
        data['name'] = $("#name").val();
        if(data['name'] == ''){
            alert("主要联系人必填");
            return false;
        }
        data['telephone'] = $("#telephone").val();
        if(data['telephone'] == ''){
            alert("手机必填");
            return false;
        }
        var reg = new RegExp("^[0-9]{11}$");
        if( ! reg.test(data['telephone'])){
            alert("请输入正确的电话号码");
            return false;
        }
        data['ticket'] = $("#ticket").val();
        if(data['ticket'] == ''){
            alert("团购券号必填");
            return false;
        }
        data['info'] = $("#info").val();
        $.ajax({
            url: '/book',
                data: data,
                dataType:'json',
                type:'POST',
                success: function(res) {           
                    if(res['status'] == 0 ){
                        alert('恭喜，预定成功，请留意我们的短信！');
                        window.location.reload(true);
                    }else{
                        alert(res['info']);
                    }
                    return false;
                },
        });
        return false;
    });
});
</script>
@endsection
