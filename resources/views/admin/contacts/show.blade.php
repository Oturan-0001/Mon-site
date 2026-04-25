@extends('layout.app')

@section('content')

<div class="admin-container">

    <h2>Détail du message</h2>

    <p><strong>Nom :</strong> {{ $contact->name }}</p>
    <p><strong>Prénom :</strong> {{ $contact->prenom }}</p>
    <p><strong>Message :</strong></p>

    <div class="message-box">
        {{ $contact->message }}
    </div>

    <a href="{{ route('admin.contacts.index') }}">Retour</a>

</div>

@endsection