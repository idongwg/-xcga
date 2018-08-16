@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="margin-top: 120px">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading panel-center">登录</div>

                    <div class="panel-body">

                        <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                <label for="username" class="col-md-4 control-label">账号</label>

                                <div class="col-md-6">
                                    <input id="username" type="username" class="form-control" name="username" value="{{ old('username') }}" required autofocus>

                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">密码</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">

                                <!--
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : ''}}> 记住我
                                    </label>
                                </div>
                                -->
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary" style="width:200px">
                                    	登录
                                    </button>
                                <!--
                                    <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                        忘记密码?
                                    </a>
                                    -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
    	.container-big {
    		
    	}
        .login {
            background-image: url("../img/login.png");
            background-size: cover;
            background-repeat: no-repeat;
        }
        .navbar-default {
        	background-color: transparent;
        	border: none;
        }
        .navbar-height {
        	margin: 54px 0;
        }
        .navbar-default .mazarine {
            color: #fff;
            font-size: 1.5vw;
        }
        .panel-center {
            text-align: center;
            font-size: 18px;
        }
        @media (min-width: 1200px) {
            .container-small {
                width: 510px;
            }
        }
    </style>
@endsection