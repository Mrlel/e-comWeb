<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function sendContact(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:120',
            'email' => 'required|email',
            'message' => 'required|string|max:2000',
        ]);

        try {
            Mail::raw(
                "De : {$data['nom']} ({$data['email']})\n\n{$data['message']}",
                function ($mail) use ($data) {
                    $mail->to(config('mail.from.address'))
                        ->subject('Nouveau message de contact — ' . config('app.name'))
                        ->replyTo($data['email'], $data['nom']);
                }
            );
        } catch (\Throwable $e) {
            Log::error('Échec envoi message de contact', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', "Votre message n'a pas pu être envoyé, veuillez réessayer plus tard.");
        }

        return back()->with('success', 'Merci, votre message a bien été envoyé. Nous vous répondrons rapidement.');
    }
}
