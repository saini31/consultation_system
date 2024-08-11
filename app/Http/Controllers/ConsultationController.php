<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
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
            'user_id' => 'required|integer|exists:users,id',
            'professional_id' => 'required|integer|exists:users,id',
            'scheduled_at' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Convert Unix timestamp to datetime (if applicable)
        $validatedData['scheduled_at'] = Carbon::createFromTimestamp($request->input('scheduled_at'))->toDateTimeString();

        // Create the consultation record
        $consultation = Consultation::create($validatedData);

        // Get the user and professional data
        $user = User::findOrFail($validatedData['user_id']);
        $professional = User::findOrFail($validatedData['professional_id']);

        // Send Firebase Notification
        $firebaseService = new FirebaseService();
        $firebaseService->sendPushNotification(
            $professional->fsm_token, // Assuming you store the token in the user model
            'New Consultation Scheduled',
            'You have a new consultation scheduled with ' . $user->name
        );


        // Send SMS notification (optional, using Twilio as an example)
        $this->sendSMSNotification($professional->phone_number, 'Your consultation has been scheduled!');

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
