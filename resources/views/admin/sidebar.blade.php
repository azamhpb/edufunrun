<div class="sidebar">

    <div class="logo">

        <div align="center" style="backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,0.15);border-radius:30px;padding:5px;box-shadow:0 10px 40px rgba(0,0,0,0.4);">
        <img src="https://yayasanangkasa.coop/images/logo%20yayasan%20angkasa%202018%201to1.png" width="100px" height="100px" alt="Logo">
        </div>
        <div align="center">
        Gala Dinner Sabah 2026
        </div>
    </div>

    <a href="{{ url('admin/dashboard') }}">
        Dashboard
    </a>

    <a href="{{ url('admin/guest') }}">
        Guest Management
    </a>

    @if(session('admin_level') == 'superadmin')

        <a href="{{ url('admin/user') }}">
            User Management
        </a>

        <a href="{{ url('admin/attendance-management') }}">
            Attendance Management
        </a>

        <a href="{{ url('admin/attendance-undo-logs') }}">
            Attendance Undo Logs
        </a>

    @endif

    @if(
        in_array(
            session('admin_level'),
            ['superadmin','supervisor']
        )
    )

        <a href="{{ url('admin/export') }}">
            Export Excel
        </a>

        <a href="{{ url('admin/settings') }}">
            Settings
        </a>

    @endif

    <a href="{{ url('admin/classes') }}">

    Classes & Table Management

    </a>

    <a href="{{ url('admin/floorplan') }}">
    Floor Plan View
    </a>

    <a href="{{ url('admin/logout') }}">
        Logout
    </a>

    <hr>

    @if(session('admin_level') == 'superadmin')

        <a
        target="_blank"
        href="{{ url('/guest_scanner/1') }}">

            Scanner 1

        </a>

        <a
        target="_blank"
        href="{{ url('/guest_scanner/2') }}">

            Scanner 2

        </a>

        <a
        target="_blank"
        href="{{ url('/guest_scanner/3') }}">

            Scanner 3

        </a>

        <hr>

        <a
        target="_blank"
        href="{{ url('/guest_screen_tv/1') }}">

            Welcome TV 1

        </a>

        <a
        target="_blank"
        href="{{ url('/guest_screen_tv/2') }}">

            Welcome TV 2

        </a>

        <a
        target="_blank"
        href="{{ url('/guest_screen_tv/3') }}">

            Welcome TV 3

        </a>

        <a
        target="_blank"
        href="{{ url('/guest_dashboard_tv') }}">

            Dashboard TV

        </a>

    @endif

</div>