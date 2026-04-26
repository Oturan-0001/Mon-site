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
        <div class="titre">
            <a href="/">VDA</a>
        </div>

        <div class="cart-container" id="open-cart" style="cursor:pointer; position:relative;">
            <span class="cart-emoji">🛒</span>
            <span id="cart-badge" class="badge">0</span>
        </div>

        <div class="menu-toggle" id="menu-toggle">☰</div>

        <ul class="page" id="nav-menu">
            <li><a href="{{ route('apropos') }}">A propos</a></li>
            <li><a href="{{ route('contact') }}">Contacts</a></li>
        </ul>

        <div class="connexion">
            @guest
                <a class="btn btn-outline" href="{{ route('register') }}">Inscription</a>
                <a class="btn btn-dark" href="{{ route('login') }}">Connexion</a>
            @else
                <a href="{{ route('dashboard') }}" class="profile-icon">👤</a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button class="btn btn-danger" type="submit">Déconnexion</button>
                </form>
            @endguest
        </div>
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

    <div id="cart-sidebar" class="cart-sidebar">
    <div class="cart-header">
        <h2>Mon Panier</h2>
        <span class="close-cart" id="close-cart" style="cursor:pointer; font-size:30px;">&times;</span>
    </div>
    <div id="cart-items-content" class="cart-items-list"></div>
    
    <div class="cart-footer">
        <div class="total-box">
            <span>Total:</span>
            <span id="cart-total-price">0 FCFA</span>
        </div>
        <button class="btn-checkout" onclick="sendToWhatsApp()">
            Commander via WhatsApp 💬
        </button>
    </div>
</div>

    
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

<script>

// Utilise un nom de clé unique pour ne pas mélanger avec d'autres projets
const CART_KEY = 'vda_cart_data';
let cart = JSON.parse(localStorage.getItem(CART_KEY)) || [];

function updateCartUI() {
    const badge = document.getElementById('cart-badge');
    const content = document.getElementById('cart-items-content');
    const totalDisplay = document.getElementById('cart-total-price');

    if(!badge || !content || !totalDisplay) return;

    // Mise à jour du badge (nombre total d'articles)
    const totalQty = cart.reduce((acc, item) => acc + item.qty, 0);
    badge.innerText = totalQty;

    // Vider et reconstruire la liste
    content.innerHTML = '';
    let totalPrice = 0;

    cart.forEach((item, index) => {
        const subTotal = item.price * item.qty;
        totalPrice += subTotal;

        content.innerHTML += `
            <div class="cart-item-row" style="display:flex; align-items:center; gap:10px; margin-bottom:15px; border-bottom:1px solid #eee; padding-bottom:10px;">
                <img src="${item.image}" style="width:50px; height:50px; object-fit:cover; border-radius:5px;">
                <div style="flex:1">
                    <div style="font-weight:bold; color:#333;">${item.name}</div>
                    <small>${item.qty} x ${item.price.toLocaleString()} FCFA</small>
                </div>
                <div style="font-weight:bold; color:#0d6efd;">${subTotal.toLocaleString()}</div>
                <button onclick="removeFromCart(${index})" style="border:none; background:none; color:red; cursor:pointer; font-size:18px;">&times;</button>
            </div>
        `;
    });

    totalDisplay.innerText = totalPrice.toLocaleString() + ' FCFA';
}

function addToCart(id, name, price, qty, image) {
    const existingIdx = cart.findIndex(item => item.id === id);
    if (existingIdx > -1) {
        cart[existingIdx].qty += parseInt(qty);
    } else {
        cart.push({ id, name, price: parseInt(price), qty: parseInt(qty), image });
    }
    saveAndRefresh();
    document.getElementById('cart-sidebar').classList.add('active');
}

function removeFromCart(index) {
    cart.splice(index, 1);
    saveAndRefresh();
}

function saveAndRefresh() {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
    updateCartUI();
}

function sendToWhatsApp() {
    if (cart.length === 0) return alert("Votre panier est vide !");
    let text = "Bonjour VDArticles, voici ma commande :\n\n";
    let total = 0;
    cart.forEach(item => {
        text += `• ${item.name} (x${item.qty}) : ${item.price * item.qty} FCFA\n`;
        total += item.price * item.qty;
    });
    text += `\n*TOTAL : ${total.toLocaleString()} FCFA*`;
    window.open(`https://wa.me/57209375?text=${encodeURIComponent(text)}`, '_blank');
}

// Événements d'ouverture/fermeture
document.getElementById('open-cart').onclick = () => document.getElementById('cart-sidebar').classList.add('active');
document.getElementById('close-cart').onclick = () => document.getElementById('cart-sidebar').classList.remove('active');

// Charger au démarrage
window.addEventListener('DOMContentLoaded', updateCartUI);

</script>

</body>
</html>