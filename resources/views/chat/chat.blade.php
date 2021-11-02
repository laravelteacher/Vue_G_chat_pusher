@extends('layouts.app')
@section('content')
<div class="container">
    <!-- in this page we can connect to Vue Js -->
    @foreach($r as $r)
    <h1>{{ $r->name }}</h1>
      </form>   
       @endforeach
       @foreach($g as $g)
      <form action="{{ url('/delete',$g->id) }}" method="post">
      @csrf
      @method('DELETE')      
    <button type="submit" class="btn btn-danger">Delete</button>
           </form>   
    @endforeach
      <chat-component :user="{{ auth()->user() }}"></chat-component>
    </div>
@endsection