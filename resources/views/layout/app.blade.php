<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset( 'css/style.css' )}}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#0d6efd">

    <!-- iOS support -->
    <link rel="apple-touch-icon" href="/icons/icon-192.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
</head>
<body>
        <nav class="navbar">
    <div class="nav-container">

        <!-- LOGO -->
        <div class="titre">
            <a href="/">VDA</a>
        </div>

        <!-- BURGER -->
        <div class="menu-toggle" id="menu-toggle">
            ☰
        </div>

        <!-- MENU -->
        <ul class="page" id="nav-menu">
            <li><a href="{{ route('apropos') }}">A propos</a></li>
            <li><a href="{{ route('contact') }}">Contacts</a></li>
            
        </ul>

        <!-- ACTIONS -->
        @guest
        <div class="connexion">
            <a class="btn btn-outline" href="{{ route('register') }}">Inscription</a>
            <a class="btn btn-dark" href="{{ route('login') }}">Connexion</a>
        </div>
        @endguest

        @auth
        <div class="connexion" id="connex-menu">

            <!-- ICONE PROFIL -->
            <a href="{{ route('dashboard') }}" class="profile-icon">
                👤
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-danger" type="submit">Déconnexion</button>
            </form>
        </div>
        @endauth

    </div>
    
</nav>

    @yield('content')


    <footer class="footer">
    <div class="footer-container">

        <!-- Logo + description -->
        <div class="footer-col">
            <h2 class="logo">VDArticles</h2>
            <p>
                Votre marketplace moderne pour trouver des produits de qualité
                au meilleur prix.
            </p>
        </div>

        <!-- Liens -->
        <div class="footer-col">
            <h3>Navigation</h3>
            <ul>
                <li><a href="/">Accueil</a></li>
                <li><a href="/apropos">À propos</a></li>
                <li><a href="/contact">Contact</a></li>
            </ul>
        </div>

        <!-- Contact -->
        <div class="footer-col">
            <h3>Contact</h3>
            <p>Email : contact@vdarticles.com</p>
            <p>Tél : +229 00 00 00 00</p>
        </div>

        <!-- Formulaire -->
        <div class="footer-col">
            <h3>Newsletter</h3>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="text" name="name" placeholder="Nom" required>
                <input type="email" name="email" placeholder="Email" required>
                <button type="submit">S'inscrire</button>
            </form>
        </div>

    </div>

    <div class="footer-bottom">
        <p>© 2026 VDArticles - Tous droits réservés</p>
    </div>
</footer>
<button id="installBtn"
        style="display:none; position:fixed; bottom:20px; right:20px; z-index:9999;">
    📲 Installer l'app
</button>

    
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then(reg => console.log('SW enregistré'))
            .catch(err => console.log('SW erreur', err));
    });
}
</script>

<script>
let deferredPrompt;

const installBtn = document.getElementById('installBtn');

// detect install possible
window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;

    installBtn.style.display = 'block';
});

// click install
installBtn.addEventListener('click', async () => {
    installBtn.style.display = 'none';

    deferredPrompt.prompt();

    const { outcome } = await deferredPrompt.userChoice;

    if (outcome === 'accepted') {
        console.log('App installée');
    }

    deferredPrompt = null;
});
</script>

</body>
</html>