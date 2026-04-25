@extends('layout.app')
@section('content')

<div class="edit-page">

    <div class="edit-card">

        <h1 class="title">Modifier le produit</h1>

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="name" value="{{ $product->name }}" required>
            </div>

            <div class="form-group">
                <label>Description</label>
                <input type="text" name="description" value="{{ $product->description }}" required>
            </div>

            <div class="form-group">
                <label>Prix</label>
                <input type="number" name="price" value="{{ $product->price }}" required>
            </div>

            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image" accept="image/*" onchange="previewImage(event)">
            </div>

            <div class="image-preview">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" id="oldImage">
                @endif

                <img id="preview" style="display:none;">
            </div>

            <button type="submit" class="btn-primary">
                💾 Mettre à jour
            </button>

        </form>

        <a href="{{ route('admin.products.index') }}" class="btn-secondary">
            ← Retour
        </a>

    </div>

</div>

<!-- JS PREVIEW IMAGE -->
<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    const oldImage = document.getElementById('oldImage');

    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = "block";

            if (oldImage) {
                oldImage.style.display = "none";
            }
        }

        reader.readAsDataURL(file);
    }
}
</script>

@endsection