@extends('layout.app')

@section('content')

<section class="contact-section">

    <div class="contact-container">

        <div class="contact-header">
            <h1>Contactez-nous</h1>
            <p>Une question ? Un problème ? Écrivez-nous 👇</p>
        </div>

        @if(session('success'))
            <p style="color: green; text-align:center;">
                {{ session('success') }}
            </p>
        @endif

        <form class="contact-form" method="POST" action="{{ route('contact.send') }}">
            @csrf

            <div class="input-group">
                <label>Nom</label>
                <input type="text" name="name" placeholder="Entrez votre nom" required>
            </div>

            <div class="input-group">
                <label>Prénom</label>
                <input type="text" name="prenom" placeholder="Entrez votre prénom" required>
            </div>

            <div class="input-group">
                <label>Message</label>
                <textarea placeholder="Entrez votre message" name="message" rows="5" required></textarea>
            </div>

            <button type="submit" class="contact-btn">Envoyer</button>

        </form>

        <p class="contact-info">
            Ou contactez-nous directement : <br>
            📧 contact@vdarticles.com <br>
            📞 +229 XX XX XX XX
        </p>

    </div>

</section>

@endsection