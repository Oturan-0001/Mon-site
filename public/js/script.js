// pour la page welcome
document.addEventListener("DOMContentLoaded", function () {

    const reveals = document.querySelectorAll('.reveal');

    function revealOnScroll() {
        const windowHeight = window.innerHeight;

        reveals.forEach(el => {
            const elementTop = el.getBoundingClientRect().top;

            if (elementTop < windowHeight - 50) {
                el.classList.add('active');
            }
        });
    }

    window.addEventListener('scroll', revealOnScroll);

    // Lancer une première fois au chargement
    revealOnScroll();
});

// Pour la page create 
function previewImage(event) {
    const preview = document.getElementById('preview');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = "block";
        }

        reader.readAsDataURL(file);
    }
}

// Responsive 


    const toggle = document.getElementById('menu-toggle');
    const menu = document.getElementById('nav-menu');

    toggle.addEventListener('click', () => {
        menu.classList.toggle('active'); 
    });

// Suppression simple

    document.querySelectorAll('.single-delete').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // bloque la suppression directe

        Swal.fire({
            title: "Supprimer ce produit ?",
            text: "Cette action est irréversible !",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dc3545",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Oui, supprimer",
            cancelButtonText: "Annuler"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // ✔ envoie le formulaire
            }
        });
    });
});
    
