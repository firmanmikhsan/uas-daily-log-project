@if (!request()->is('login*') && !request()->is('register*'))
<nav class="navbar navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" alt="" width="30" height="24" class="d-inline-block align-text-top"> Sistem Informasi Daily Log
        </a>
    </div>
</nav>
@endif