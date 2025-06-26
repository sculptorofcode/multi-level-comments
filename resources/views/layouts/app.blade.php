<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Multi-Level Comments')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('posts.index') }}">
                <i class="fas fa-comments me-2"></i>Multi-Level Comments
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('posts.create') }}">
                    <i class="fas fa-plus me-1"></i>Create Post
                </a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="main-container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h5><i class="fas fa-comments"></i> About Us</h5>
                    <p>Multi-Level Comments is a modern discussion platform that enables deep, nested conversations and meaningful interactions.</p>
                </div>
                <div class="footer-section">
                    <h5><i class="fas fa-link"></i> Quick Links</h5>
                    <ul>
                        <li><a href="{{ route('posts.index') }}">Home</a></li>
                        <li><a href="{{ route('posts.create') }}">Create Post</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h5><i class="fas fa-envelope"></i> Contact Us</h5>
                    <p>Email: softwaredevsaikat@gmail.com</p>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="footer-social">
                    <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" title="GitHub"><i class="fab fa-github"></i></a>
                </div>
                <p class="mb-1">
                    &copy; {{ date('Y') }} Multi-Level Comments. Built with 
                    <i class="fas fa-heart text-danger"></i> using Laravel & Bootstrap.
                </p>
                <p class="mb-0">
                    <small>Designed for meaningful conversations and community building.</small>
                </p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
