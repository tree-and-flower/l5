@extends('framework-admin')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">修改客户信息</h4>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading"></div>
                <div class="panel-body">
                <div class="col-lg-5">
                <form role="form"   method="POST">
                        <div class="form-group">
                            <input class="form-control" name="id" id="id" type="hidden" value="{{$customer['id']}}" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label">景点名称</label>
                                <select class="form-control" name="jingdian" id="jingdian">
                                @foreach ($jingdianConf as $k => $v)
                                <option value="{{$k}}" @if($k == $customer['jingdian'])selected @endif>{{$v}}</option>
                                @endforeach
                                </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">商家名称</label>
                                <select class="form-control" name="shangjia" id="shangjia">
                                @foreach ($shangjiaConf as $k => $v)
                                <option value="{{$k}}" @if($k == $customer['shangjia'])selected @endif>{{$v}}</option>
                                @endforeach
                                </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">出行日期</label>
                            <input class="form-control" placeholder="点击选择出行日期" style="background-color:#FFF" name="travel_at" id="travel_at" type="text" readonly="readonly" value="{{date('Y-m-d',strtotime($customer['travel_at']))}}">
                        </div>
                        <div class="form-group">
                            <label class="control-label">主要联系人</label>
                            <input class="form-control" placeholder="请输入主要联系人姓名" name="name" id="name" type="text" value="{{$customer['name']}}">
                        </div>
                        <div class="form-group">
                            <label class="control-label">手机</label>
                                <input class="form-control" placeholder="请输入主要联系人手机" name="telephone" id="telephone" type="text" value="{{$customer['telephone']}}">
                        </div>
                        <div class="form-group">
                            <label class="control-label">身份证号码</label>
                            <input class="form-control" placeholder="请输入身份证号码" name="id_card" id="id_card" type="text" value="{{$customer['id_card']}}">
                        </div>
                        <div class="form-group">
                            <label class="control-label">团购券号(多个券号以逗号，分隔)</label>
                                <textarea class="form-control" rows="5" name="ticket" id="ticket"  placeholder="多个券号以逗号分隔" >{{$customer['ticket']}}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label">备注(可填写人数信息)</label>
                                <textarea class="form-control" rows="1" name="info" id="info" placeholder="备注信息" >{{$customer['info']}}</textarea>
                        </div>
                        <button type="button" id="editCustomer"  class="btn btn-large btn-warning btn-block">提交</button>
                </form>
                </div>
                </div>
            </div>
        </div>
</div>
@endsection
@section('js')
<script type="text/javascript" src="/js/laydate/laydate.js"></script>
<script type="text/javascript">
!function(){
    laydate.skin('molv');//切换皮肤，请查看skins下面皮肤库
    laydate({
        elem: '#travel_at',
            festival: true, //显示节日
            min: laydate.now(0), 
    });
}();

</script>
<script>
$(document).ready(function(){
    $('#editCustomer').click(function(){
        var data = {};
        data['id'] = $("#id").val();
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
        data['id_card'] = $("#id_card").val();
        data['ticket'] = $("#ticket").val();
        if(data['ticket'] == ''){
            alert("团购券号必填");
            return false;
        }
        data['info'] = $("#info").val();
        $.ajax({
            url: '/customer/edit',
                data: data,
                dataType:'json',
                type:'POST',
                success: function(res) {           
                    if(res['status'] == 0 ){
                        alert('更新成功');
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
