<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<x-app-layout>
<br>

<x-slot name="header">
    <h2 class="fw-bold text-dark">
        Dashboard
    </h2>
</x-slot>

<div class="dashboard-wrap">
    <div class="container-fluid">

        <div class="card shadow-sm border-0 p-3">

            <!-- FORM GLOBAL -->
            <form action="{{ route('admin.products.bulkDelete') }}" method="POST" id="bulkForm">
                @csrf
                @method('DELETE')

                <!-- TOP BAR -->
                <div class="d-flex justify-content-between align-items-center mb-4">

                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        ➕ Ajouter un produit
                    </a>

                    <div>
                        <button type="button" class="btn btn-danger" id="deleteModeBtn">
                            🗑️ Supprimer
                        </button>

                        <button type="submit" class="btn btn-dark d-none" id="confirmDeleteBtn">
                            ✔ Confirmer
                        </button>
                    </div>

                </div>

                <!-- TABLE -->
                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light">
                            <tr>
                                <th class="select-col d-none">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th>Image</th>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Prix</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($products as $product)

                            <tr>

                                <!-- CHECKBOX -->
                                <td class="select-col d-none">
                                    <input type="checkbox" 
                                           name="selected_products[]" 
                                           value="{{ $product->id }}" 
                                           class="product-checkbox">
                                </td>

                                <td>
                                    <img src="{{ asset('storage/'.$product->image) }}" width="70" height="70">
                                </td>

                                <td class="fw-bold">{{ $product->name }}</td>

                                <td>{{ Str::limit($product->description, 50) }}</td>

                                <td class="text-primary fw-bold">
                                    {{ number_format($product->price, 0, ',', ' ') }} FCFA
                                </td>

                                <td>

                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                                        ✏️
                                    </a>

                                    <!-- SUPPRESSION SIMPLE -->
                                    <form action="{{ route('admin.products.destroy', $product) }}" 
                                        method="POST" 
                                        class="d-inline single-delete"
                                        data-name="{{ $product->name }}"
                                        data-image="{{ asset('storage/'.$product->image) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            🗑️
                                        </button>
                                    </form>

                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="6" class="text-center">
                                    Aucun produit trouvé.
                                </td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </form>
            <br>

            <div class="btn btn-primary">
                <a href="{{ route('admin.contacts.index') }}">Voir mes contacts</a>
            </div>

        </div>
                
    </div>
</div>

</x-app-layout>


<!-- JS -->
<script>
const deleteBtn = document.getElementById('deleteModeBtn');
const confirmBtn = document.getElementById('confirmDeleteBtn');
const selectCols = document.querySelectorAll('.select-col');
const checkboxes = document.querySelectorAll('.product-checkbox');
const selectAll = document.getElementById('select-all');
const singleDeletes = document.querySelectorAll('.single-delete');

let deleteMode = false;

// ✅ UN SEUL EVENT
deleteBtn.addEventListener('click', () => {

    deleteMode = !deleteMode;

    selectCols.forEach(col => col.classList.toggle('d-none'));

    confirmBtn.classList.toggle('d-none');

    singleDeletes.forEach(el => {
        el.style.display = deleteMode ? 'none' : 'inline';
    });

    // reset si on annule
    if (!deleteMode) {
        checkboxes.forEach(cb => cb.checked = false);
        if (selectAll) selectAll.checked = false;
    }

    deleteBtn.textContent = deleteMode ? "❌ Annuler" : "🗑️ Supprimer";
});

// SELECT ALL
if (selectAll) {
    selectAll.addEventListener('change', () => {
        checkboxes.forEach(cb => cb.checked = selectAll.checked);
    });
}

// CONFIRMATION
confirmBtn.addEventListener('click', (e) => {

    const checked = document.querySelectorAll('.product-checkbox:checked');

    if (checked.length === 0) {
        e.preventDefault();
        alert("Veuillez sélectionner au moins un produit !");
        return;
    }

    if (!confirm('Supprimer les produits sélectionnés ?')) {
        e.preventDefault();
    }
});

//Suppression simple

document.querySelectorAll('.single-delete').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const productName = form.dataset.name;
        const productImage = form.dataset.image;

        Swal.fire({
            title: "Supprimer ce produit ?",
            html: `
                <p><strong>${productName}</strong></p>

                <div style="display:flex; justify-content:center; margin-top:10px;">
                    <img src="${productImage}" 
                        style="width:120px; height:120px; object-fit:cover; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.2);">
                </div>

                <p style="margin-top:10px;">Cette action est irréversible</p>
            `,
           
            showCancelButton: true,
            confirmButtonColor: "#dc3545",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Oui, supprimer",
            cancelButtonText: "Annuler"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>