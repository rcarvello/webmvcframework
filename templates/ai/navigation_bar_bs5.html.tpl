<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <div class="container">
        <a class="navbar-brand" href="{GLOBAL:SITEURL}">{RES:ProjectName}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarBs5"
                aria-controls="navbarBs5" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarBs5">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item active"><a class="nav-link" href="{GLOBAL:SITEURL}">{RES:Home}</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">{RES:Contacts}</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">{RES:Setting}</a>
                    <ul class="dropdown-menu">
                        <li><h6 class="dropdown-header">{RES:LanguageSettings}</h6></li>
                        <li><a class="dropdown-item" href="?locale=en">{RES:English}</a></li>
                        <li><a class="dropdown-item" href="?locale=it-it">{RES:Italian}</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><h6 class="dropdown-header">{RES:GuiSettings}</h6></li>
                        <li><a class="dropdown-item" href="">{RES:LookAndFeel}</a></li>
                    </ul>
                </li>
            </ul>
            <a class="btn btn-outline-secondary btn-sm" href="{GLOBAL:SITEURL}/examples/">{RES:Exit}</a>
        </div>
    </div>
</nav>
