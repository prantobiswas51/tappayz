<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KycController extends Controller
{
    public function submit_kyc(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',

            'street_address' => 'required|string|max:255',
            'apt_unit' => 'nullable|string|max:255',
            'zip_code' => 'required|string|max:20',

            'phone_number' => 'required|string|max:20',
            'email_address' => 'required|email|max:255',

            'country' => 'required|string|max:100',
            'passport_number' => 'required|string|max:100',
            'passport_img' => 'nullable|image|max:2048',
        ]);

        $path = null;

        if ($request->hasFile('passport_img')) {
            $path = $request->file('passport_img')->store('passport_img', 'public');
        }

        // Save or update KYC record
        \App\Models\Kyc::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'date_of_birth' => $request->date_of_birth,
                'street_address' => $request->street_address,
                'apt_unit' => $request->apt_unit,
                'zip_code' => $request->zip_code,
                'phone_number' => $request->phone_number,
                'email_address' => $request->email_address,
                'country' => $request->country,
                'passport_number' => $request->passport_number,
                'passport_img_path' => $path, // saved path
                'status' => 'Pending',
            ]
        );

        $html = '
            <div style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
                <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px;
                            box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden;">
                    <div style="background-color: #4a90e2; color: #ffffff; padding: 20px; text-align: center;">
                        <h1 style="margin: 0; font-size: 22px;">KYC Information Submitted</h1>
                    </div>
                    <div style="padding: 30px; text-align: center;">
                        <h2 style="color: #333333;">Your KYC Details Have Been Received</h2>
                        <p style="color: #555555; font-size: 16px; line-height: 1.6;">
                            Thank you for submitting your KYC information. Your details have been 
                            <strong>successfully received</strong> and are currently <strong>under review</strong> by our compliance team.
                        </p>
                        <div style="margin: 25px auto; background-color: #f1f3f5; border-radius: 8px;
                                    padding: 15px; max-width: 400px; text-align: left; color: #222;">
                            <p><strong>Status:</strong> Pending Verification</p>
                            <p><strong>Date Submitted:</strong> ' . now()->format("F j, Y, g:i A") . '</p>
                        </div>
                        <p style="color: #555555; font-size: 15px; line-height: 1.6;">
                            We’ll notify you by email once your KYC verification is complete. 
                            This process typically takes up to 24–48 hours.
                        </p>
                        <a href="https://tappayz.com/kyc"
                        style="display: inline-block; background-color: #4a90e2; color: #ffffff;
                                padding: 12px 25px; border-radius: 6px; text-decoration: none;
                                font-weight: bold; margin-top: 15px;">
                            View Verification Status
                        </a>
                    </div>
                    <div style="background-color: #f1f3f5; padding: 15px; text-align: center; font-size: 13px; color: #777;">
                        <p>Need help? Contact our support team at 
                            <a href="mailto:support@tappayz.com" style="color: #4a90e2;">support@tappayz.com</a>
                        </p>
                        <p>© ' . date("Y") . ' Tappayz. All rights reserved.</p>
                    </div>
                </div>
            </div>
        ';

        sendCustomMail(Auth::user()->email, 'Tappayz - KYC Information Submitted', $html);


        return redirect()->route('kyc')->with('status', 'KYC information submitted successfully.');
    }
}
