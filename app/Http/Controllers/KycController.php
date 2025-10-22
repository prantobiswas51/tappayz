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

        return redirect()->route('kyc')->with('status', 'KYC information submitted successfully.');
    }
}
