@extends('layout.app')

@section('content')

<div class="form-page">

    <div class="form-card">

        <h1>Ajouter un produit</h1>
        <p class="subtitle">Remplissez les informations du produit</p>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label>Description</label>
                <input type="text" name="description" required>
            </div>

            <div class="form-group">
                <label>Prix</label>
                <input type="number" name="price" required>
            </div>

            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image" accept="image/*" onchange="previewImage(event)">
            </div>

            <!-- PREVIEW IMAGE -->
            <div class="image-preview">
                <img id="preview" style="display:none;">
            </div>

            <button type="submit" class="btn-submit">
                ➕ Ajouter le produit
            </button>

        </form>

        <a href="{{ route('dashboard') }}" class="back-link">← Retour</a>

    </div>

</div>

@endsection