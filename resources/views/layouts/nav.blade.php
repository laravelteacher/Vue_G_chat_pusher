<div class="navba">
    <a href="{{ url('/home') }}">
       {{ config('app.name', 'Laravel') }}
    </a>

  @guest
    @if (Route::has('login'))
      <a href="{{ route('login') }}">{{ __('Login') }}</a>
    @endif
    @if (Route::has('register'))
      <a href="{{ route('register') }}">{{ __('Register') }}</a>
    @endif

  @else
  <a class="btn btn-light" href="/group/create">Make group</a>
  <a class="btn btn-light" href="/subscribe">Join group</a>
  @if($users)
     
    @else
    @endif
    <div class="dropdow">
      <button class="dropbt">
        Hello {{ Auth::user()->name }} 
        <i class="fa fa-caret-down"></i>
    </button>
    
      <div class="dropdown-content">
        <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
           @csrf
        </form>
        <div class="header">
           @endguest
        </div>   
      </div>
    </div> 
</div>