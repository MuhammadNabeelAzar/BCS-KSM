<html>
    <head>
        <title>Restaurant Management System</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">    
    </head>
    <body>
        <!--      navbar-->
        <nav class="navbar navbar-expand-sm navbar-light bg-light"style="height:fit-content">
            <div class="container-fluid">
                <div class="d-flex flex-column datetime m-2">
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
                <div class="heading">
                    <h1 align="center">User Management</h1>
                </div>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto"> <!-- Use "ml-auto" to push items to the right -->
                        <button type="button" class="btn btn-light" id="bell"><i class="bi  bi-bell"></i></button>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Account
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#"><Span><i class="bi bi-lock"></i></Span>Settings</a></li>
                                <li><a class="dropdown-item" href="#"><span><i class="bi bi-box-arrow-right"></i></span>Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <hr>
        <div style="display:flex;">
                <button id="sidebarCollapseButton" class="btn btn-primary d-block d-sm-none">
                    Toggle Sidebar
                </button>

                <div class="side-bar"style="width:fit-content;">
                    <nav id="sidebarMenu" class="collapse d-sm-block sidebar collapse bg-white">
                        <div class="side-nav">
                            <div class="list-group list-group-flush " style="width:fit-content;text-align:center;padding:20px;height:270px;justify-content:space-around">
                                <div>
                                    <a href="../view/add-users.php" class="list-group-item-action py-2 ripple" aria-current="true" style="text-decoration:none;">
                                        <span>Add Users</span>
                                    </a>
                                </div>
                                <div>
                                    <a href="../view/edit-user.php" class="list-group-item-action py-2 ripple" aria-current="true" style="text-decoration:none;">
                                        <span>View & Edit Users</span>
                                    </a>
                                </div>

                                <div>
                                    <a href="../view/remove-users.php" class="list-group-item-action py-2 ripple" aria-current="true" style="text-decoration:none;">
                                        <span>Remove Users</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </nav> 
                </div>
                <div class="section" style="width:100%;"></div> 
            </div>
       




        <script type="text/javascript">
            function updateClock() {
                var now = new Date();
                var dname = now.getDay(),
                        mo = now.getMonth(),
                        dnum = now.getDate(),
                        yr = now.getFullYear(),
                        hou = now.getHours(),
                        min = now.getMinutes(),
                        sec = now.getSeconds(),
                        pe = "AM";
                if (hou == 0) {
                    hou = 12;
                }
                if (hou > 12) {
                    hou = hou - 12;
                    pe = "PM";
                }
                Number.prototype.pad = function (digits) {
                    for (var n = this.toString(); n.length < digits; n = 0 + n)
                        ;
                    return n;

                }

                var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                var week = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                var ids = ["dayname", "month", "daynum", "year", "hour", "minutes", "seconds", "period"];
                var values = [week[dname], months[mo], dnum.pad(2), yr, hou.pad(2), min.pad(2), sec.pad(2), pe];
                for (var i = 0; i < ids.length; i++)
                    document.getElementById(ids[i]).firstChild.nodeValue = values[i];
            }
            function initClock() {
                updateClock();
                window.setInterval(updateClock, 1000);
            }
            initClock();
        </script>
        <script>
                document.addEventListener('DOMContentLoaded', function(){
                    const sidebarMenu = document.getElementById('sidebarMenu');
                const sidebarCollapseButton = document.getElementById('sidebarCollapseButton');

                sidebarCollapseButton.addEventListener('click',function() {
                    sidebarMenu.classList.toggle('show');
                });
                });
        </script>        
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>