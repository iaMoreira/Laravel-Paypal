<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="{{route('home')}}">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto navbar-">
      <li class="nav-item active">
        <a class="nav-link" href="{{route('cart')}}">
            Meu Carrinho<i class="fa fa-shopping-cart " aria-hidden="true"></i>
            <span class="badge badge-secondary">
                @if (session('cart'))
                    {{session('cart')->totalItems()}}
                @else
                    0
                @endif
            </span>
        </a>
      </li>
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Entrar</a>
            </li>
            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Cadastra-se</a>
                </li>
            @endif
        @else
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="{{route('profile')}}">Perfil</a>
                <a class="dropdown-item" href="">Alterar Senha</a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    Sair
                    </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                </div>
            </li>
        @endguest

    </ul>

  </div>
</nav>
