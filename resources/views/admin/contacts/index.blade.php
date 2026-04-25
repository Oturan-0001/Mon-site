@extends('layout.app')

@section('content')

<div class="admin-container">

    <h1>Messages reçus</h1>

    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Message</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($contacts as $contact)
                <tr>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->prenom }}</td>
                    <td>{{ Str::limit($contact->message, 50) }}</td>
                    <td>
                        <a href="{{ route('admin.contacts.show', $contact->id) }}">Voir</a>

                        <form method="POST" action="{{ route('admin.contacts.destroy', $contact->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>

</div>

@endsection