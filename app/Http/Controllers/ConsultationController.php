<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Notifications\ConsultationScheduled;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
use App\Notifications\UserNotification;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConsultationScheduledMail;
use Twilio\Rest\Client;




class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        $query = Consultation::query();

        if ($request->has('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        if ($request->has('professional_id')) {
            $query->where('professional_id', $request->input('professional_id'));
        }

        $consultations = $query->get();

        return response()->json(['consultations' => $consultations]);
    }

    // Retrieve a single consultation by ID
    public function show($id)
    {
        $consultation = Consultation::find($id);

        if (!$consultation) {
            return response()->json(['message' => 'Consultation not found'], 404);
        }

        return response()->json(['consultation' => $consultation]);
    }

    // Store a new consultation


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'professional_id' => 'required|integer',
            'scheduled_at' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Convert Unix timestamp to datetime (if applicable)
        $availableAt = Carbon::createFromTimestamp($request->input('available_at'))->toDateTimeString();

        // Create the consultation record
        $consultation = Consultation::create($validatedData);

        // Get the user and professional data
        $user = User::find($validatedData['user_id']);
        $professional = User::find($validatedData['professional_id']);

        // Send real-time notification
        $user->notify(new  \App\Notifications\UserNotification('Your consultation has been scheduled!'));


        // Send email notification
        Mail::to($user->email)->send(new ConsultationScheduledMail($consultation));

        // Send SMS notification (optional, using Twilio as an example)
        $this->sendSMSNotification($user->phone_number, 'Your consultation has been scheduled!');

        return response()->json(['message' => 'Consultation created and notifications sent!'], 201);
    }
    private function sendSMSNotification($phoneNumber, $message)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_NUMBER');

        $client = new Client($sid, $token);
        $client->messages->create(
            $phoneNumber,
            [
                'from' => $twilioNumber,
                'body' => $message,
            ]
        );
    }



    // Update an existing consultation
    public function update(Request $request, $id)
    {
        $consultation = Consultation::find($id);

        if (!$consultation) {
            return response()->json(['message' => 'Consultation not found'], 404);
        }

        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'professional_id' => 'required|integer',
            'scheduled_at' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $consultation->update($validatedData);

        return response()->json(['consultation' => $consultation]);
    }

    // Delete a consultation
    public function destroy($id)
    {
        $consultation = Consultation::find($id);

        if (!$consultation) {
            return response()->json(['message' => 'Consultation not found'], 404);
        }

        $consultation->delete();

        return response()->json(['message' => 'Consultation deleted successfully']);
    }
    // public function schedule(Request $request)
    // {
    //     $consultation = Consultation::create([
    //         'user_id' => Auth::id(),
    //         'date' => $request->date,
    //         'time' => $request->time,
    //         'description' => $request->description,
    //     ]);

    //     return redirect()->route('userProfile', ['id' => Auth::id()])
    //         ->with('success', 'Consultation scheduled successfully');
    // }
}
