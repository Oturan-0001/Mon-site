@extends('layout.app')

@section('content')

<div class="hero">
    <h1>Bienvenue sur <span>VDArticles</span></h1>
    <p>Trouvez tout ce dont vous avez besoin</p>
    <p class="sub">Travail, cuisine ou quotidien — tout est ici pour vous simplifier la vie.</p>
</div>

<div class="products">
    @forelse($products as $product)
        <div class="product-card reveal">
            <div class="image-wrapper" style="position: relative;">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                <a href="{{ route('products.show', $product) }}" class="btn-add-quick" title="Ajouter au panier">
                    +
                </a>
            </div>

            <div class="product-content">
                <div class="product-title">{{ $product->name }}</div>
                <div class="product-price">
                    {{ number_format($product->price, 0, ',', ' ') }} FCFA
                </div>
                <a href="{{ route('products.show', $product) }}" class="btn-detail">Voir détails</a>
            </div>
        </div>
    @empty
        <p class="empty">Aucun produit disponible pour le moment.</p>
    @endforelse
</div>

<style>
    /* Petit plus pour l'esthétique du bouton + */
    .btn-add-quick {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: #28a745; /* Vert */
        color: white;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-weight: bold;
        font-size: 20px;
        transition: transform 0.2s;
    }
    .btn-add-quick:hover { transform: scale(1.1); background: #218838; }
</style>

@endsection