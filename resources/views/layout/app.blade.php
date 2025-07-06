<!DOCTYPE html>
<html lang="en" data-bs-theme="{{ auth()->check() ? auth()->user()->theme : 'light' }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'My Laravel App')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ✅ Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1;
        }
    </style>
</head>
<body>

    <!-- ✅ Navbar with toggle button -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">MyApp</a>

            <div class="d-flex align-items-center gap-2">
                {{-- Theme toggle --}}
                @auth
                    <button class="btn btn-sm btn-outline-light" id="theme-toggle">Toggle Theme</button>
                    
                    <span class="text-light">Hi, {{ auth()->user()->name }}</span>

                    <form action="/logout" method="POST" class="d-inline ms-2">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light">Logout</button>
                    </form>
                @else
                    @if (request()->routeIs('login'))
                        <a href="{{ route('register')}}" class="btn btn-sm btn-outline-light">Register</a>
                    @elseif (request()->routeIs('register'))
                        <a href="{{route('login')}}" class="btn btn-sm btn-outline-light">Login</a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <!-- ✅ Main -->
    <main class="container mb-4">
        @yield('content')
    </main>

    <!-- ✅ Footer -->
    <footer class="bg-dark text-light text-center py-3 mt-auto">
        &copy; {{ date('Y') }} Hatem's App. All rights reserved.
    </footer>

    <!-- ✅ Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ✅ Theme Switcher Script -->
    @auth
    <script>
        const html = document.documentElement;
        const toggleBtn = document.getElementById('theme-toggle');

        toggleBtn?.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            html.setAttribute('data-bs-theme', newTheme);

            fetch("/theme-toggle", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ theme: newTheme }),
            });
        });
    </script>
    @endauth

</body>
</html>
