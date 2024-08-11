<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Mail;

use App\Notifications\ConsultationScheduled;
use Illuminate\Support\Facades\Notification;


use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use App\Http\Controllers\check;
use \Illuminate\Support\Facades\Facades;



class AuthController extends Controller
{
    public function register(Request $request)
    {
        //dd($request); // This will dump the request and stop execution

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
        // dd($validator);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Generate token
        $token = Str::random(60);

        // Store token
        $user->remember_token = hash('sha256', $token);
        // $iiii = $user->save(); // Make sure to save the user with the token
        // dd($iiii);
        // Return a JSON response with success message and token
        return response()->json([
            'message' => 'User registered successfully',
            'token' => $token,
            'user' => $user
        ], 201);
    }


    //use App\Models\User;

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // Generate token
            $token = Str::random(60);
            // Store token (you might want to save it in your database or session)
            $user->remember_token = hash('sha256', $token);
            // $user->save();

            // Return a JSON response with the token and user data
            return response()->json([
                'token' => $token,
                'user' => $user
            ], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
    // public function logout(Request $request){
    //     $user=Request()->user();
    //     $user=tokens()->delete();
    //     return response()->json(['message'=>'logout successfully'],200);
    // }

    public function logout(Request $request)
    {

        $user = $request->user();
        //dd($user);
        // Delete tokens stored in the user table
        $user->update(['remember_token' => null]); // Assuming 'tokens' is the field name storing tokens

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
    //use App\Models\User;

    public function index(Request $request)
    {
        // Remove dd($request);
        $users = User::all();
        // dd($users);
        return response()->json(['users' => $users]);
    }
    public function getbyID($id)
    {
        // Retrieve the user by their ID
        $user = User::find($id);

        // Check if the user exists
        if ($user) {
            // User found, return the user data
            return $user->toArray();
            return response()->json(['user' => $user->toArray()]); // Convert user object to array
        } else {
            // User not found, return an empty array or handle the error
            return []; // or return response()->json(['error' => 'User not found'], 404);
        }
    }
    // use Illuminate\Support\Facades\Mail;
    //use Illuminate\Support\Facades\URL;
    // use Illuminate\Support\Str;
    //use App\Models\User;
    public function userProfile($id)
    {

        $user = User::find($id);
        //dd($user);
        if ($user) {
            return view('profile', ['user' => $user]);
        } else {
            return redirect()->route('userList')->with('error', 'User not found');
        }
    }
    public function sendVerifyMail($email)
    {
        if ($email) {
            $user = User::where('email', $email)->first();

            if ($user) {
                $random = Str::random(40);
                $url = URL::to('/') . '/' . $random;

                $data = [
                    'url' => $url,
                    'email' => $email,
                    'title' => "Email Verification",
                    'body' => "Please click on the link to verify your email.",
                ];

                Mail::send('email', ['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'])->subject($data['title']);
                });

                $user->update(['remember_token' => $random]);

                return response()->json(['success' => true, 'msg' => 'Mail sent successfully']);
            } else {
                return response()->json(['success' => false, 'msg' => 'User is not authorized'], 403);
            }
        } else {
            return response()->json(['success' => false, 'msg' => 'Invalid email provided'], 400);
        }
    }
    public function sendNotification(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'professional_id' => 'required|integer',
            'scheduled_at' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $user = User::find($request->input('user_id'));

        // Define consultation details
        $consultation = [
            'user_id' => $request->input('user_id'),
            'professional_id' => $request->input('professional_id'),
            'scheduled_at' => $request->input('scheduled_at'),
            'notes' => $request->input('notes'),
            'id' => $request->input('consultation_id') // Include the consultation ID
        ];
        dd($consultation);
        // Send notification
        Notification::send($user, new ConsultationScheduled($consultation));

        return response()->json(['message' => 'Notification sent successfully.'], 200);
    }
}
