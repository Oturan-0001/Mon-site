@extends('layout.app')

@section('content')

<div class="hero">
    <h1>Bienvenue sur <span>VDArticles</span></h1>
    <p>Trouvez tout ce dont vous avez besoin</p>
    <p class="sub">
        Travail, cuisine ou quotidien — tout est ici pour vous simplifier la vie.
    </p>
</div>

<div class="products">

    @forelse($products as $product)

        <div class="product-card reveal">

            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">

            <div class="product-content">

                <div class="product-title">
                    {{ $product->name }}
                </div>

                <div class="product-price">
                    {{ number_format($product->price, 0, ',', ' ') }} FCFA
                </div>

                <a href="{{ route('products.show', $product) }}" class="btn-detail">
                    Voir détails
                </a>

            </div>

        </div>

    @empty

        <p class="empty">Aucun produit disponible pour le moment.</p>

    @endforelse

</div>

@endsection