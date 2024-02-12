<nav class="navbar navbar-header navbar-expand-sm ">
    <div class="container-fluid">
        <div class="d-flex flex-row datetime m-2 align-items-center">
            <div class="d-flex flex-column m-2">
            <a class="btn custom-outline-button btn-lg" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
                aria-controls="offcanvasExample">
                <i class="bi bi-list"></i>
            </a>
            </div>
            <div class="d-flex flex-column ">
                <div class="date">
                    <span id="dayname">Day</span>
                    <span id="month">Month</span>:
                    <span id="daynum">00</span>
                    <span id="year">Year</span>
                </div>
                <div class="time">
                    <span id="hour">00</span>:
                    <span id="minutes">00</span>:
                    <span id="seconds">00</span>:
                    <span id="period">AM</span>
                </div>
            </div>

        </div>

        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent"
            style="margin-right:75px;">
            <ul class="navbar-nav ml-auto"> <!-- Use "ml-auto" to push items to the right -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false" >
                        <h7>Account</h7>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown" >
                        <li><a class="dropdown-item" href="../../../commons/reset-password.php"><Span><i
                                        class="bi bi-lock"></i></Span>Password Settings</a>
                        </li>
                        <li><a class="dropdown-item" href="../../../../controller/logout_controller.php"><span><i
                                        class="bi bi-box-arrow-right"></i></span>Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>