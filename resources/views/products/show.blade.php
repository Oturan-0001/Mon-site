@extends('layout.app')

@section('content')

<div class="product-detail">

    <!-- BOUTON RETOUR -->
    <a href="{{ route('home') }}" class="btn-back">
        ← Retour à l'accueil
    </a>

    <div class="product-container">

        <!-- IMAGE -->
        <div class="product-image">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
        </div>

        <!-- INFOS -->
        <div class="product-info">

            <h1>{{ $product->name }}</h1>

            <div class="price">
                {{ number_format($product->price, 0, ',', ' ') }} FCFA
            </div>

            <p class="description">
                {{ $product->description }}
            </p>

            <div class="actions">
                <a href="https://wa.me/57209375?text=Bonjour je veux le produit {{ $product->name }}" 
                   target="_blank" 
                   class="btn-whatsapp">
                    💬 Commander sur WhatsApp
                </a>
            </div>

        </div>

    </div>

</div>

@endsection