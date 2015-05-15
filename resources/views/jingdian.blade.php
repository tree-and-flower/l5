@extends('framework-admin')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">海洋世界</h4>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
            <form class="form-inline" method="get">
                <span>商家</span>
                <select id="shangjiaSelect" name="shangjia" class="form-control">
                    <option value="0" @if ($shangjia == 0) selected="selected" @endif>全部</option>
                    @foreach ($shangjiaConf as $k => $v)
                        <option value="{{$k}}" @if($shangjia == $k) selected="selected" @endif>{{$v}}</option>
                    @endforeach
                </select>
                <span>验证</span>
                <select id="isVerifySelect" name="is_verify" class="form-control">
                    <option value="-1" @if ($is_verify == -1) selected="selected" @endif>全部</option>
                    <option value="0" @if ($is_verify == 0) selected="selected" @endif>未验证</option>
                    <option value="1" @if ($is_verify == 1) selected="selected" @endif>已验证</option>
                </select>
                <span>退款</span>
                <select id="isRefundSelect" name="is_refund" class="form-control">
                    <option value="-1" @if ($is_refund == -1) selected="selected" @endif>全部</option>
                    <option value="0" @if ($is_refund == 0) selected="selected" @endif>未退款</option>
                    <option value="1" @if ($is_refund == 1) selected="selected" @endif>已退款</option>
                </select>
                <input type="text" name="name" value="{{$name}}" class="form-control" placeholder="联系人">
                <input type="text" name="telephone" value="{{$telephone}}" class="form-control" placeholder="手机">
                <input type="submit" value="查询" class="btn btn-info">
            </form>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
<div class="widget-box">
    <div class="widget-content nopadding">
        <div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
            <table class="table table-bordered table-striped table-hover with-check">
                <thead>
                    <tr>
                        <th>id</th>
                        <th style="width:50px">商家</th>
                        <th style="width:80px">联系人/手机</th>
                        <th style="width:90px">出行日期</th>
                        <th>下单日期</th>
                        <th style="width:100px">卷号</th>
                        <th style="width:70px">备注</th>
                        <th class="op">操作</th>
                    </tr>
                </thead>
                <tbody id="sortableTable">
                    @foreach ($customers as $one)
                    <!--tr @if ($one->is_verify == 0)style="color: #E72020;"@endif -->
                    <tr @if ($one->is_refund == 1) class="danger" @elseif ($one->is_verify == 1) class="success" @endif >
                        <td>
                            {{$one->id}}
                        </td>
                        <td>
                            {{str_limit($shangjiaConf[$one->shangjia], 2, '')}}
                        </td>
                        <td>
                            {{$one->name}}
                            {{$one->telephone}}
                        </td>
                        <td>
                            {{date('Y-m-d', strtotime($one->travel_at))}}
                        </td>
                        <td>
                            {{date('Y-m-d H:i:s', strtotime($one->created_at))}}
                        </td>
                        <td>
                            {{$one->ticket}}
                        </td>
                        <td>
                            {{$one->info}}
                        </td>
                        <td align="center">
                            @if ($one->is_verify == 0)
                            <input type="button" targetid="{{$one->id}}" value="验证" class="btn btn-xs btn-success verifyOne">
                            @else
                            <input type="button" targetid="{{$one->id}}" value="取验" class="btn btn-xs btn-warning unverifyOne">
                            @endif

                            @if ($one->is_refund == 0)
                            <input type="button" targetid="{{$one->id}}" value="退款" class="btn btn-xs btn-success refundOne">
                            @else
                            <input type="button" targetid="{{$one->id}}" value="取退" class="btn btn-xs btn-warning unrefundOne">
                            @endif
                            <input type="button" targetid="{{$one->id}}" value="删除" class="btn btn-xs btn-danger delOne">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {!! $customers->appends($appends)->render() !!}
    </div>
</div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</div>
@stop
@section('js')
<script>
var table = $("#sortableTable");
table.on('click', '.delOne', function(){
    var r = confirm('确定删除该联系人?');
    if(r==true){
        var id = $(this).attr('targetid');
        var url = '/jingdian/delCustomer/' + id;
        var data = {};
        $.ajax({
            type: "POST",
                url: url,
                data: data,
                dataType: 'json',
                success:function(rs){
                    if(rs.status == 0){
                        window.location.reload();
                    }else{
                        alert(rs.info);
                    }
                }
        });
    }
    return true;
});
table.on('click', '.verifyOne', function(){
    var r = confirm('确定通过验证该联系人?');
    if(r==true){
        var id = $(this).attr('targetid');
        var url = '/jingdian/verifyCustomer/' + id;
        var data = {};
        $.ajax({
            type: "POST",
                url: url,
                data: data,
                dataType: 'json',
                success:function(rs){
                    if(rs.status == 0){
                        window.location.reload();
                    }else{
                        alert(rs.info);
                    }
                }
        });
    }
    return true;
});

table.on('click', '.unverifyOne', function(){
    var r = confirm('确定取消验证该联系人?');
    if(r==true){
        var id = $(this).attr('targetid');
        var url = '/jingdian/unverifyCustomer/' + id;
        var data = {};
        $.ajax({
            type: "POST",
                url: url,
                data: data,
                dataType: 'json',
                success:function(rs){
                    if(rs.status == 0){
                        window.location.reload();
                    }else{
                        alert(rs.info);
                    }
                }
        });
    }
    return true;
});
//退款/取消退款
table.on('click', '.refundOne', function(){
    var r = confirm('确定退款该联系人?');
    if(r==true){
        var id = $(this).attr('targetid');
        var url = '/jingdian/refundCustomer/' + id;
        var data = {};
        $.ajax({
            type: "POST",
                url: url,
                data: data,
                dataType: 'json',
                success:function(rs){
                    if(rs.status == 0){
                        window.location.reload();
                    }else{
                        alert(rs.info);
                    }
                }
        });
    }
    return true;
});

table.on('click', '.unrefundOne', function(){
    var r = confirm('确定取消退款该联系人?');
    if(r==true){
        var id = $(this).attr('targetid');
        var url = '/jingdian/unrefundCustomer/' + id;
        var data = {};
        $.ajax({
            type: "POST",
                url: url,
                data: data,
                dataType: 'json',
                success:function(rs){
                    if(rs.status == 0){
                        window.location.reload();
                    }else{
                        alert(rs.info);
                    }
                }
        });
    }
    return true;
});
</script>

@stop
