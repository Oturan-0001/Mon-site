@extends('layout.app')

@section('content')
<div class="product-detail">
    <a href="{{ route('home') }}" class="btn-back">← Retour à l'accueil</a>

    <div class="product-container">
        <div class="product-image">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
        </div>

        <div class="product-info">
            <h1>{{ $product->name }}</h1>
            <div class="price">
                <span id="unit-price" data-value="{{ $product->price }}">
                    {{ number_format($product->price, 0, ',', ' ') }}
                </span> FCFA
            </div>

            <p class="description">{{ $product->description }}</p>

            <div class="order-controls" style="margin: 20px 0; padding: 20px; background: #fdfdfd; border: 1px solid #eee; border-radius: 12px;">
                <label style="font-weight: bold; color: #555;">Quantité :</label>
                <div style="display: flex; align-items: center; gap: 20px; margin-top: 10px;">
                    <button type="button" onclick="changeQty(-1)" class="qty-btn" aria-label="Diminuer">-</button>
                    
                    <span id="qty-display" style="font-weight: bold; font-size: 1.5rem;">1</span>
                    
                    <button type="button" onclick="changeQty(1)" class="qty-btn" aria-label="Augmenter">+</button>
                </div>
                
                <div style="margin-top: 20px; font-size: 1.2rem; border-top: 1px dashed #ddd; padding-top: 10px;">
                    Total : <span style="color: #0d6efd; font-weight: bold;"><span id="total-price">{{ number_format($product->price, 0, ',', ' ') }}</span> FCFA</span>
                </div>
            </div>

            <div class="actions" style="display: flex; flex-direction: column; gap: 10px;">
                <button onclick="saveToCart()" class="btn-cart" style="background: #007bff; color: white; border: none; padding: 12px; border-radius: 5px; cursor: pointer;">
                    🛒 Ajouter au panier
                </button>

                <a href="https://wa.me/57209375?text=Bonjour, je souhaite commander {{ $product->name }}" 
                   id="whatsapp-link" target="_blank" class="btn-whatsapp">
                    💬 Commander sur WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    let quantity = 1;
    const unitPrice = parseInt(document.getElementById('unit-price').dataset.value);

    function changeQty(value) {
        quantity += value;
        if (quantity < 1) quantity = 1;
        
        document.getElementById('qty-display').innerText = quantity;
        const total = quantity * unitPrice;
        document.getElementById('total-price').innerText = total.toLocaleString();

        const wsLink = document.getElementById('whatsapp-link');
        wsLink.href = `https://wa.me/57209375?text=Bonjour, je souhaite commander ${quantity} x {{ $product->name }} (Total: ${total} FCFA)`;
    }

    // VERSION OPTIMISÉE : On appelle directement la fonction du layout
    function saveToCart() {
        // On utilise la fonction addToCart définie dans app.blade.php
        addToCart(
            "{{ $product->id }}",
            "{{ $product->name }}",
            unitPrice,
            quantity,
            "{{ asset('storage/' . $product->image) }}"
        );

        // Optionnel : afficher un petit message de succès avec SweetAlert2 (déjà importé dans ton layout)
        Swal.fire({
            icon: 'success',
            title: 'Ajouté !',
            text: 'Le produit est dans votre panier',
            timer: 1500,
            showConfirmButton: false
        });
    }
</script>

<style>
    /* Boutons + et - */
    .qty-btn { 
        width: 40px; 
        height: 40px; 
        cursor: pointer; 
        border: 2px solid #0d6efd; /* Bordure bleue pour bien voir */
        background-color: white; 
        color: #0d6efd; /* Texte bleu */
        border-radius: 8px; 
        font-weight: bold; 
        font-size: 20px; /* Plus grand pour la visibilité */
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .qty-btn:hover {
        background-color: #0d6efd;
        color: white;
    }

    /* Le chiffre entre les deux */
    #qty-display {
        min-width: 30px;
        text-align: center;
        color: #333;
    }

    .btn-whatsapp { 
        text-align: center; 
        background: #25d366; 
        color: white; 
        padding: 12px; 
        border-radius: 5px; 
        text-decoration: none; 
        font-weight: bold;
    }
    
    .product-detail {
        padding: 20px;
        max-width: 1000px;
        margin: auto;
    }
</style>
@endsection