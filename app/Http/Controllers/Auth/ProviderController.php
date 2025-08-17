<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use App\Models\Provider;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class ProviderController extends Controller
{
    /**
     * Redirect to the provider for authentication.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToProvider(Request $request)
    {
        $providerValue = $request->provider;

        // Validate the provider to ensure it's supported
        if (!in_array($providerValue, ['google'])) {
            return redirect()->route('welcome')->with('error', 'Unsupported provider.');
        }

        // Store the previous URL to redirect back after login
        session()->put('previous_url', url()->previous());

        return Socialite::driver($providerValue)->stateless()->redirect();
    }

    /**
     * Handle the provider callback after authentication.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback(Request $request)
    {
        $providerValue = $request->provider;

        if (!in_array($providerValue, ['google'])) {
            return redirect()->route('welcome')->with('error', 'Unsupported provider.');
        }

        $previousUrl = $request->session()->pull('previous_url', route('welcome'));
        $providerUser = Socialite::driver($providerValue)->stateless()->user();
        
        try {
            DB::beginTransaction();

            // Check if provider account exists
            $provider = Provider::where('provider', $providerValue)
                ->where('provider_id', $providerUser->getId())
                ->first();

            if ($provider) {
                $user = $provider->user;
            } else {
                // Check if user exists with same email
                $user = User::where('email', $providerUser->getEmail())->first();

                if (!$user) {
                    // Get patient role
                    $patientRole = Role::where('name', 'patient')->first();

                    // Create new user
                    $user = User::create([
                        'name' => $providerUser->getName(),
                        'email' => $providerUser->getEmail(),
                        'password' => Hash::make(Str::random(24)),
                        'email_verified_at' => now(),
                        'avatar' => $providerUser->getAvatar(),
                        'role_id' => $patientRole->id
                    ]);

                    $nameArr = explode(" ", $providerUser->getName());

                    // Create related patient and associate
                    $patient = Patient::create([
                        'first_name' => $nameArr[0],
                        'last_name' => $nameArr[1] ?? null,
                    ]);

                    $patient->user()->associate($user);
                    $patient->save();
                }

                // Create provider record
                Provider::create([
                    'user_id' => $user->id,
                    'provider' => $providerValue,
                    'provider_id' => $providerUser->getId(),
                    'provider_token' => $providerUser->token,
                    'avatar' => $providerUser->getAvatar(),
                    'name' => $providerUser->getName(),
                    'nickname' => $providerUser->getNickname(),
                    'token' => $providerUser->token,
                ]);
            }

            DB::commit();

            Auth::login($user);

            return redirect($previousUrl);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('welcome')->with('error', 'Authentication failed. Please try again.');
        }
    }
}
