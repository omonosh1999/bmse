<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

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
        // Validate the form data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'student_level' => 'nullable|string|in:primary,secondary,adult,teacher',
            'inquiry_type' => 'required|string|in:online_courses,live_classes,physical_classes,teacher_training,textbooks,curriculum,general,other',
            'message' => 'required|string|max:1000',
            'newsletter' => 'nullable|boolean'
        ], [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'inquiry_type.required' => 'Please select an inquiry type.',
            'message.required' => 'Message is required.',
            'student_level.in' => 'Please select a valid student level.',
            'inquiry_type.in' => 'Please select a valid inquiry type.'
        ]);

        try {
            // Send email to admin
            Mail::to('info@brilliantmath.com')->send(new ContactFormMail($validated));
            
            // If newsletter subscription is checked, you might want to add them to a mailing list
            if ($validated['newsletter'] ?? false) {
                // Add to newsletter logic here
                // For now, we'll just log it or save to database
            }

            // Redirect back with success message
            return redirect()->route('contact')->with('success', 
                'Thank you for your message! We\'ll get back to you within 24 hours.'
            );

        } catch (\Exception $e) {
            // Log the error
            \Log::error('Contact form submission failed: ' . $e->getMessage());
            
            // Redirect back with error message
            return redirect()->route('contact')->with('error', 
                'Sorry, there was an issue sending your message. Please try again or call us directly.'
            )->withInput();
        }
    }
}