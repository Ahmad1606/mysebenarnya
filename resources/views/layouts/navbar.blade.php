<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">MySebenarnya</a>
        <div class="d-flex">
            @auth
                <a class="btn btn-outline-light me-2" href="{{ route('profile') }}">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-light" type="submit">Logout</button>
                </form>
            @else
                <a class="btn btn-outline-light me-2" href="{{ route('login') }}">Login</a>
                <a class="btn btn-outline-light" href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    </div>
</nav>
