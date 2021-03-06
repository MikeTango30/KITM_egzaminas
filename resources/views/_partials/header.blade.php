<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">Bank</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link" href="{{ url('/') }}">My Accounts</a>
            <a class="nav-item nav-link" href="{{ url('/send-payment/form') }}">Send Payment</a>
            <a class="nav-item nav-link" href="{{ url('/send-self/form') }}">Payments between my account</a>
            <a class="nav-item nav-link" href="{{ url('/logout') }}">Logout</a>
        </div>
    </div>
</nav>
