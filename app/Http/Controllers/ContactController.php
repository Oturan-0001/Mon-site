<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function store(Request $request){
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Sauvegarde
        Contact::create([
            'name' => $request->name,
            'prenom' => $request->prenom,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Message envoyé avec succès');
    }
}
