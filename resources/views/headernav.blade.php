    <nav class="navbar navbar-dark bg-dark fixed-top p-1">
        <div class="container-fluid">
        
        
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
           
        <a class="navbar-brand" href="{{ route('order_tracking.index') }}">
        <i class="fas fa-home me-2"></i> District Collectorate, Revenue Department, Sangareddy
        </a>
           

            <div class="header_user">
                <span id="live-time"></span>
            </div>

            <div class="dropdown">
                <button class="btn btn-warning dropdown-toggle header_user_icon" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle fa-1x"></i> {{ Auth::user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('password.change') }}">Change Password</a></li>
                <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                </ul>

            </div>
            
        </div>
    </nav>