@extends('framework')

@section('content')
<div class="container">
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">请登录</h3>
            </div>
            <div class="panel-body">
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    登录出现一下错误.<br><br>
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
                @endif
                <form role="form" method="POST" action="{{ url('/auth/login') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <fieldset>
                        <div class="form-group">
                            <input class="form-control" placeholder="邮箱" name="email" type="email" autofocus>
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="密码" name="password" type="password" value="">
                        </div>
                        <div class="checkbox">
                            <label>
                                <input name="remember" type="checkbox" value="Remember Me">记住我
                            </label>
                        </div>
                        <!-- Change this to a button or input when using this as a form -->
                        <button type="submit" class="btn btn-lg btn-success btn-block">登录</button>
                        <a class="btn btn-link" href="{{ url('/password/email') }}">忘记密码?</a>
                        <a class="btn btn-link" href="{{ url('/auth/register') }}">注册</a>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
