<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Show the contact form
     */
    public function show()
    {
        return view('contact');
    }

    /**
     * Handle contact form submission
     */
    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        try {
            // You can either send an email or store in database
            // For now, we'll just log the contact submission
            Log::info('Contact form submission', [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'submitted_at' => now(),
            ]);

            // Optionally, send an email notification
            // Mail::to('admin@bmse.com')->send(new ContactFormSubmission($request->all()));

            return back()->with('success', 'Thank you for your message! We will get back to you soon.');
            
        } catch (\Exception $e) {
            Log::error('Contact form submission failed', [
                'error' => $e->getMessage(),
                'data' => $request->all(),
            ]);

            return back()->with('error', 'Sorry, there was an error sending your message. Please try again later.');
        }
    }
}