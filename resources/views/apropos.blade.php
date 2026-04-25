@extends('layout.app')
@section('content')

<section class="about">

    <div class="about-header">
        <h1>Qui sommes-nous ?</h1>
        <p>Découvrez notre univers et notre mission</p>
    </div>

    <div class="about-images">
        <img src="{{ asset('image/cullotte2.jpg') }}" alt="">
        <img src="{{ asset('image/image1.jpg') }}" alt="">
        <img src="{{ asset('image/image2.jpg') }}" alt="">
    </div>

    <div class="about-content">

        <p>
            Votre destination incontournable pour des tenues modernes, élégantes et accessibles pour hommes, femmes et enfants.
        </p>

        <p>
            Notre mission est simple : vous offrir un style qui vous ressemble, au meilleur rapport qualité-prix.
        </p>

        <p>
            Depuis notre création, nous sélectionnons avec soin chaque article pour garantir style, confort et durabilité.
            Que vous recherchiez une tenue du quotidien, un look tendance ou une pièce unique pour une occasion spéciale, Alfredshop vous accompagne dans toutes vos envies mode.
        </p>

        <p>
            Nous proposons également une large collection de chaussures alliant qualité, style et praticité.
        </p>

        <h3>Pourquoi choisir VDArticles ?</h3>

        <ul class="about-list">
            <li>🛍️ Collection variée pour toute la famille</li>
            <li>👗 Produits sélectionnés avec soin</li>
            <li>💸 Prix accessibles</li>
            <li>🚚 Livraison rapide</li>
            <li>🤝 Service client disponible</li>
        </ul>

    </div>

</section>

@endsection

    