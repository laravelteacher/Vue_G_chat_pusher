<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- user id, will be used in vuejs for the real time chat -->
    @if (!Auth::guest())
        <meta name="user-id" content="{{ Auth::user()->id }}">
    @endif
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>

</head>
<body class='darkkhaki'>
<div id="app">
    
    @include('layouts.nav')
    <div class="row">
          <div class="col-md-2 center">
             @if (!Auth::guest())
               @foreach($users as $user)
              <ul>
                <li class="user liUser" id="{{ $user->id }}">
                  <div class="media-body">
                     <!-- <p class="name">{{ $user->name }}</p> -->
                     <a class='liA_user' href="/chats/{{ $user->id }}">{{ $user->name }}</a>
                  </div>
                </li>
              </ul>
         @endforeach
        @endif
    </div>
    <div class="col-md-10">
     @yield('content')
    </div>
  </div>
</div>
<script src="{{asset('js/app.js')}}"></script>

<style>
        .dropbtn {
           background-color: #3498DB;
           color: white;
           padding: 16px;
           font-size: 16px;
           border: none;
           cursor: pointer;
           width: 44px;
        }

        .dropbtn:hover, .dropbtn:focus {
           background-color: #2980B9;
        }

        .dropdown {
           position: relative;
           display: inline-block;
           position: relative;
    right: 24px;
        }

        .dropdown-content {
           display: none;
           position: absolute;
           background-color: #f1f1f1;
           min-width: 160px;
           overflow: auto;
           box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
           z-index: 1;
       }

       .dropdown-content a {
           color: black;
           padding: 12px 16px;
           text-decoration: none;
           display: block;
        }

        .dropdown a:hover {background-color: #ddd;}

        .show {display: block;}

        /* width */  
        ::-webkit-scrollbar {
            width: 7px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #a7a7a7;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #929292;
        }

        ul {
            margin: 0;
            padding: 0;
        }

        li {
            list-style: none;
        }

        .user-wrapper, .message-wrapper {
            border: 1px solid #dddddd;
            overflow-y: auto;
        }

        .user-wrapper {
            height: 600px;
        }

        .use,.user {
            cursor: pointer;
            padding: 5px 0;
            position: relative;
        }

        .user:hover {
            background: #eeeeee;
        }

        .user:last-child {
            margin-bottom: 0;
        }

        .pending {
            position: absolute;
            left: 13px;
            top: 9px;
            background: red;
            margin: 0;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            line-height: 18px;
            padding-left: 5px;
            color: #ffffff;
            font-size: 12px;
        }

        .pendin {                                  
            position: absolute;
            left: 13px;
            top: 9px;
            background: red;
            margin: 0;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            line-height: 18px;
            padding-left: 5px;
            color: #ffffff;
            font-size: 12px;
        }

        .media-left {
            margin: 0 10px;
        }

        .media-left img {
            width: 64px;
            border-radius: 64px;
        }

        .media-body p {
            margin: 6px 0;
        }

        .message-wrapper {
            padding: 10px;
            height: 536px;
            background: ;
        }

        .messages {
            height: 5%;
        }

        .messages .message {
            margin-bottom: 15px;
        }

        .messages .message:last-child {
            margin-bottom: 0;
        }

        .received, .sent {
            width: 45%;
            padding: 3px 10px;
            border-radius: 10px;
        }

        .received {
            background: lightgray;
        }

        .sent {
            background: orange;
            float: right;
            text-align: right;
        }

        .message p {
            margin: 5px 0;
        }

        .date {
            color: #777777;
            font-size: 12px;
        }

        .active {
            background: #eeeeee;
        }

        input[type=text] {
            width: 100%;
            padding: 12px 20px;
            margin: 15px 0 0 0;
            display: inline-block;
            border-radius: 4px;
            box-sizing: border-box;
            outline: none;
            border: 1px solid #cccccc;
        }

        input[type=text]:focus {
            border: 1px solid #aaaaaa;
        }
        .btn-light {
           background-color: black;
           border-color: #f8f9fa;
           color: cornsilk;
        }

        .media-body p {
           margin: 6px 0;
           color: currentcolor;
           font-size: 35px;
           font-weight: 900;
        }

        .darkkhaki{
           background-color: darkkhaki;
        }
        .darkgray{
            background-color: darkgray;
        }

        .form{
            background-color:gray;
        }

        .cyan{
            color:cyan;
        }

        .black{
            background-color:black;
        }

        .weight{
            font-weight: 600;
        }

        .top{
            top: 60px;
            position: relative;
        }

        .white{
            color:white
        }

        .padding{

        }

        .center{
            text-align: center;
        }

        .liUser{
            padding: 27px;
            background: black;
            border: 1px solid white
        }

        .liA_user{
            color:white
        }
  /* Nav */
.navba {
  overflow: hidden;
  background-color: #333;
  font-family: Arial, Helvetica, sans-serif;
}

.navba a {
  float: left;
  font-size: 16px;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.dropdow {
  float: right;
  overflow: hidden;
}

.dropdow .dropbt {
  font-size: 16px;  
  border: none;
  outline: none;
  color: white;
  padding: 14px 16px;
  background-color: inherit;
  font: inherit;
  margin: 0;
}

.navba a:hover, .dropdow:hover .dropbt {
  background-color: red;
  color:white;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: green;
  width: 10%;
  right: 0;
 
}
.dropdow:hover .dropdown-content {
  display: block;
}

</style>
</body>
</html>