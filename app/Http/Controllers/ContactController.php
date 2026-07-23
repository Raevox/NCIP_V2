<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10'
        ]);

        try {
            Log::info('📧 CONTACT FORM RECEIVED:', $validated);

            // ✅ BEST SOLUTION: Use replyTo and clear labeling
            Mail::send([], [], function ($mailMessage) use ($validated) {
                $mailMessage->to('ninoemmanueltadeo@gmail.com')
                          ->replyTo($validated['email'], $validated['name'])
                          ->subject("📧 CONTACT: {$validated['name']} - " . ($validated['subject'] ?: 'Website Inquiry'))
                          ->html("
                              <h2>💌 NEW WEBSITE CONTACT</h2>
                              
                              <div style='background: #e8f5e8; padding: 15px; border-radius: 8px; margin: 10px 0;'>
                                  <h3>👤 CONTACT INFORMATION</h3>
                                  <p><strong>Name:</strong> {$validated['name']}</p>
                                  <p><strong>Email:</strong> <a href='mailto:{$validated['email']}'>{$validated['email']}</a></p>
                                  <p><strong>Phone:</strong> " . ($validated['phone'] ?: 'Not provided') . "</p>
                                  <p><strong>Subject:</strong> " . ($validated['subject'] ?: 'General Inquiry') . "</p>
                              </div>

                              <div style='background: #f0f8ff; padding: 15px; border-radius: 8px; margin: 10px 0;'>
                                  <h3>💬 MESSAGE</h3>
                                  <p>{$validated['message']}</p>
                              </div>

                              <hr>
                              <p><em>📩 Sent from NCIP Nueva Ecija website contact form</em></p>
                              <p><strong>⚠️ TO REPLY:</strong> Use 'Reply' button to respond directly to {$validated['name']}</p>
                          ");
            });

            return redirect()->route('contacts')
                ->with('success', '✅ Thank you for your message! We will respond to your email soon.');

        } catch (\Exception $e) {
            Log::error('❌ Email error: ' . $e->getMessage());
            return back()->with('error', '❌ System error. Please try again or contact us directly.');
        }
    }
}
