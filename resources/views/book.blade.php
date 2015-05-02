@extends('framework')

@section('content')
<div class="container">
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">欢迎使用同行旅游网预约系统</h3>
            </div>
            <div class="panel-body">
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    登录出现一下错误:<br><br>
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
                @endif
                <form role="form" method="POST" action="{{ url('/book') }}">
                    <fieldset>
                        <div class="form-group">
                            <label class="control-label">预约景点名称</label>
                            <select class="form-control" name="jingdian">
                            <option value="0">请选择</option>
                            @foreach ($jingdianConf as $k => $v)
                            <option value="{{$k}}" @if($k == $jingdian)selected @endif>{{$v}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">商家来源名称</label>
                            <select class="form-control" name="shangjia">
                            <option value="0">请选择</option>
                            @foreach ($shangjiaConf as $k => $v)
                            <option value="{{$k}}" @if($k == $shangjia)selected @endif>{{$v}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">使用日期</label>
                            <input class="form-control" placeholder="" name="username" type="text" autofocus>
                        </div>
                        <div class="form-group">
                            <label class="control-label">联系人</label>
                            <input class="form-control" placeholder="请输入联系人姓名" name="username" type="text" autofocus>
                        </div>
                        <div class="form-group">
                            <label class="control-label">手机</label>
                            <input class="form-control" placeholder="请输入联系人手机" name="telephone" type="text" autofocus>
                        </div>
                        <div class="form-group">
                            <label class="control-label">团购券号</label>
                            <input class="form-control" placeholder="请输入正确的团购券号" name="ticket" type="text" value="">
                        </div>
                        <div class="form-group">
                            <label class="control-label">备注</label>
                            <textarea class="form-control" rows="2" name="info"></textarea>
                        </div>
                        <button type="submit" class="btn btn-lg btn-warning btn-block">立即预约</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
