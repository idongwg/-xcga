<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>环卫车辆移动车牌采集系统 - @yield('title')</title>

    <!-- Styles -->
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
    <style>
    	.navbar-default {
    		background-color: #2B3643;
    		border-color: transparent;
    	}
    	.navbar-default .navbar-brand:hover, .navbar-default .navbar-brand:focus {
    		color: #fff;
    	}
        .navbar-default .navbar-brand {
        	color: #fff;
        }
        .navbar-default .navbar-nav > li > a {
        	color: #79869A;
        }
        .container-big {
        	width: 100%;
        }
        .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
        	color: #79869A;
        }
        .navbar-default .navbar-nav > .open > a, 
	    .navbar-default .navbar-nav > .open > a:hover, 
	    .navbar-default .navbar-nav > .open > a:focus {
	    	background-color: #3F4F62;
	    	color: #79869A;
	    }
	    .dropdown-menu {
	    	min-width: 115px;
	    }
	    .dropdown-menu > li > a {
	    	color: #676767;
	    	text-align: left;
	    }
    </style>
</head>
<body class="login">
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container container-small container-big">
            <div class="navbar-header navbar-height">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand mazarine navbar-index" href="{{ url('/') }}">
                    <!--西城公安分局-->环卫车辆移动车牌采集系统
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <!-- <li><a href="{{ url('/login') }}">登录</a></li> -->
                    <!--<li><a href="{{ url('/register') }}">Register</a></li>-->
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <!--<i class="el-icon-service" style="font-size: 20px;"></i>-->
                                {{ Auth::user()->realname }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                	<a href="">修改密码</a>
                                    <a href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">退出登录</a>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>

                        <!--<li class="dropdown">
                            <a href="" class="dropdown-toggle">
                                <i class="el-icon-setting" style="font-size: 18px;"></i>
                            </a>
                        </li> -->
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
</div>

<!-- Scripts -->
<script src="{{ url('js/app.js') }}"></script>
</body>
</html>
