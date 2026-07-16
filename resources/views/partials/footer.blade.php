<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Presbusy Assurance Partners')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <span class="gold-text">Presbusy</span> Assurance Partners
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="/services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="/team">Our Team</a></li>
                    <li class="nav-item"><a class="nav-link" href="/contact">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer with REAL details from your PDF -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5 class="gold-text">Presbusy Assurance Partners</h5>
                    <p>Your trusted partner in insurance and estate claims.</p>
                    <p style="font-size: 0.9rem; opacity: 0.7;">
                        Honeybourne Place, Jessop Avenue,<br>
                        Cheltenham, GL50 33H, United Kingdom
                    </p>
                </div>
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <p>
                        📞 <a href="tel:+447520672457">+447520672457</a><br>
                        ✉️ <a href="mailto:Bellwoodprestbury.assurancepartners@consultant.com" style="word-break: break-all;">
                            Bellwoodprestbury.assurancepartners@consultant.com
                        </a>
                    </p>
                </div>
                <div class="col-md-4">
                    <h5>Office Hours</h5>
                    <p>Mon – Saturday: 9:00 AM – 8:00 PM</p>
                    <p style="font-size: 0.85rem; opacity: 0.7;">Closed on Sundays</p>
                </div>
            </div>
            <div class="text-center mt-3 small" style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1.5rem;">
                &copy; {{ date('Y') }} Presbusy Assurance Partners. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp & Live Chat (frontend placeholders) -->
    <div class="floating-buttons">
        <a href="https://wa.me/447520672457" class="whatsapp-btn" target="_blank" title="Chat on WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
       <button class="chat-btn" onclick="openChat()" title="Live Support">
    <i class="fas fa-comment"></i>
</button>
    </div>

    @stack('scripts')
</body>
</html>