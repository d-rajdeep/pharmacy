<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Pharmacy Management System Dashboard">
    <meta name="author" content="Rajdeep">

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/drugs.png') }}">
    <title>Dashboard - Pharmacy Management</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="{{ asset('assets/extra-libs/c3/c3.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif !important;
            background-color: #f8fafc;
            /* Softer background */
        }

        /* Modern Navbar Shadow */
        .topbar {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03) !important;
        }

        /* Sidebar Modernization */
        .left-sidebar {
            box-shadow: 2px 0 12px rgba(0, 0, 0, 0.03);
            border-right: 1px solid #f1f5f9;
        }

        .sidebar-nav ul .sidebar-item .sidebar-link {
            border-radius: 8px;
            /* Rounded pill look */
            margin: 2px 12px;
            padding: 10px 15px;
            transition: all 0.2s ease-in-out;
        }

        .sidebar-nav ul .sidebar-item .sidebar-link.active,
        .sidebar-nav ul .sidebar-item .sidebar-link:hover {
            background-color: #eff6ff !important;
            /* Soft blue hover */
            color: #1d4ed8 !important;
        }

        .sidebar-nav ul .sidebar-item .sidebar-link.active i,
        .sidebar-nav ul .sidebar-item .sidebar-link:hover i {
            color: #1d4ed8 !important;
        }

        /* Search Bar Modernization */
        .customize-input input {
            background-color: #f1f5f9 !important;
            border-radius: 20px !important;
            /* Pill shape */
            padding-left: 35px !important;
        }

        /* Disabled Menu Fix */
        .disabled-menu {
            pointer-events: none;
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>
