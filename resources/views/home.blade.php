@extends('layouts.app')
@section('content')
<div class="container-fluid">
      @if ($message = Session::get('success'))
        <div class="alert alert-success">
           <p>{{ $message }}</p>
        </div>
      @endif
</div>
@endsection