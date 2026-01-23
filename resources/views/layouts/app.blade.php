<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Billiard Management System')</title>
    <link rel="stylesheet" href="{{ asset('css/billiard.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1rem 2rem;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar h1 {
            font-size: 1.8rem;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .nav-links a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .btn {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            border: none;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-danger {
            background: #ff6b6b;
            color: white;
        }

        .btn-danger:hover {
            background: #ff5252;
        }

        .btn-success {
            background: #51cf66;
            color: white;
        }

        .btn-success:hover {
            background: #40c057;
        }

        .alert {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .table th {
            background: #667eea;
            color: white;
            padding: 1rem;
            text-align: left;
        }

        .table td {
            padding: 1rem;
            border-bottom: 1px solid #ddd;
        }

        .table tr:hover {
            background: #f9f9f9;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #333;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }

        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }

        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-pending {
            background: #cfe2ff;
            color: #084298;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .table-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-left: 5px solid #667eea;
        }

        .table-card h3 {
            color: #667eea;
            margin-bottom: 0.5rem;
        }

        .table-card p {
            margin-bottom: 0.5rem;
            color: #666;
        }

        .price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #667eea;
            margin-top: 1rem;
        }

        .status-available {
            color: #51cf66;
        }

        .status-booked {
            color: #ffa94d;
        }

        .status-maintenance {
            color: #ff6b6b;
        }

        .footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: 3rem;
        }

        .summary {
            background: #f0f4ff;
            padding: 1.5rem;
            border-radius: 10px;
            border-left: 5px solid #667eea;
        }

        .summary h3 {
            color: #667eea;
            margin-bottom: 1rem;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid #ddd;
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .summary-total {
            font-size: 1.3rem;
            font-weight: bold;
            color: #667eea;
            margin-top: 1rem;
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>🎱 Billiard Management</h1>
        <div class="nav-links">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('tables.index') }}">Meja Billiard</a>
            <a href="{{ route('bookings.index') }}">Pesanan Saya</a>
            <a href="{{ route('payments.list') }}">Pembayaran</a>
            @if (Auth::check())
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem;">Logout</button>
                </form>
                <span>{{ Auth::user()->name }}</span>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
            @endif
        </div>
    </div>

    <div class="container">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </div>

    <div class="footer">
        <p>&copy; 2026 Billiard Management System. All rights reserved.</p>
    </div>

    <script src="{{ asset('js/billiard.js') }}"></script>
</body>
</html>
