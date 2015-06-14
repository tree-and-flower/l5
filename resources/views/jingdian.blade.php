@extends('framework-admin')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">{{$jingdianConf[$jingdian]}}</h4>
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
                <span>消费</span>
                <select id="isConsumeSelect" name="is_consume" class="form-control">
                    <option value="-1" @if ($is_consume == -1) selected="selected" @endif>全部</option>
                    <option value="0" @if ($is_consume == 0) selected="selected" @endif>未消费</option>
                    <option value="1" @if ($is_consume == 1) selected="selected" @endif>已消费</option>
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
                        <th>商家</th>
                        <th>联系人/手机</th>
                        <th>出行日期</th>
                        <th>下单日期</th>
                        <th>备注</th>
                        <th class="op">操作</th>
                    </tr>
                </thead>
                <tbody id="sortableTable">
                    @foreach ($customers as $one)
                    <tr @if ($one->is_consume == 1) class="success" @endif >
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
                            {{$one->info}}
                        </td>
                        <td align="center">
                            <div class="btn-group">
                            @if ($one->is_consume == 0)
                            <input type="button" targetid="{{$one->id}}" value="消费" class="btn btn-xs btn-success consumeOne">
                            @else
                            <input type="button" targetid="{{$one->id}}" value="取消" class="btn btn-xs btn-warning unconsumeOne">
                            @endif
                            </div>
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
table.on('click', '.consumeOne', function(){
    var r = confirm('确定通过消费该联系人?');
    if(r==true){
        var id = $(this).attr('targetid');
        var url = '/jingdian/consumeCustomer/' + id;
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

table.on('click', '.unconsumeOne', function(){
    var r = confirm('确定取消消费该联系人?');
    if(r==true){
        var id = $(this).attr('targetid');
        var url = '/jingdian/unconsumeCustomer/' + id;
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
