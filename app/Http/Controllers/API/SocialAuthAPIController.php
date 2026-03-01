<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\RoleRepository;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\JWK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SocialAuthAPIController extends Controller
{
    private RoleRepository $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function login(string $provider, Request $request)
    {
        try {
            $this->validate($request, [
                'id_token' => 'required|string',
                'device_token' => 'nullable|string',
                'name' => 'nullable|string',
                'phone_number' => 'nullable|string',
            ]);

            $idToken = $request->input('id_token');
            $payload = null;
            $emailVerified = false;

            switch (strtolower($provider)) {
                case 'google':
                    [$payload, $emailVerified] = $this->verifyGoogleIdToken($idToken);
                    break;
                case 'apple':
                    [$payload, $emailVerified] = $this->verifyAppleIdToken($idToken);
                    break;
                default:
                    return $this->sendError('Unsupported provider', 400);
            }

            if (!$payload || empty($payload['email'])) {
                return $this->sendError('Invalid identity token or email not available', 200);
            }

            $email = $payload['email'];
            $name = $request->input('name')
                ?? ($payload['name'] ?? trim(($payload['given_name'] ?? '') . ' ' . ($payload['family_name'] ?? '')))
                ?? 'User';

            $user = User::where('email', $email)->first();
            if (!$user) {
                $user = new User();
                $user->name = $name ?: 'User';
                $user->email = $email;
                if ($request->filled('phone_number')) {
                    $user->phone_number = $request->input('phone_number');
                }
                if ($emailVerified && property_exists($user, 'email_verified_at')) {
                    // If the model has email_verified_at column
                    $user->email_verified_at = now();
                }
                $user->device_token = $request->input('device_token', '');
                $user->password = Hash::make(Str::random(20));
                $user->api_token = Str::random(60);
                $user->save();

                // Assign default roles
                $defaultRoles = $this->roleRepository->findByField('default', '1');
                $defaultRoles = $defaultRoles->pluck('name')->toArray();
                if (!empty($defaultRoles)) {
                    $user->assignRole($defaultRoles);
                }
            } else {
                // Existing user -> update device token and ensure api_token exists
                $user->device_token = $request->input('device_token', $user->device_token ?? '');
                if (empty($user->api_token)) {
                    $user->api_token = Str::random(60);
                }
                $user->save();
            }

            return $this->sendResponse($user->load('roles'), 'User retrieved successfully');
        } catch (ValidationException $e) {
            return $this->sendError(array_values($e->errors()));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 200);
        }
    }

    /**
     * Verify Google ID token via Google tokeninfo endpoint and client_id audience check.
     * @param string $idToken
     * @return array{0: array|null, 1: bool} [payload, emailVerified]
     */
    protected function verifyGoogleIdToken(string $idToken): array
    {
        try {
            $response = Http::timeout(10)->get('https://oauth2.googleapis.com/tokeninfo', [
                'id_token' => $idToken,
            ]);
            if (!$response->ok()) {
                return [null, false];
            }
            $payload = $response->json();
            $aud = $payload['aud'] ?? null;
            $clientId = setting('google_app_id');
            if ($clientId && $aud !== $clientId) {
                return [null, false];
            }
            $iss = $payload['iss'] ?? '';
            if (!in_array($iss, ['accounts.google.com', 'https://accounts.google.com'], true)) {
                return [null, false];
            }
            $emailVerified = filter_var($payload['email_verified'] ?? false, FILTER_VALIDATE_BOOLEAN);
            return [$payload, $emailVerified];
        } catch (Exception $e) {
            return [null, false];
        }
    }

    /**
     * Verify Apple identity token using Apple's JWKS and JWT validation.
     * @param string $idToken
     * @return array{0: array|null, 1: bool} [payload, emailVerified]
     */
    protected function verifyAppleIdToken(string $idToken): array
    {
        try {
            // Decode header to get kid and alg (handled internally by JWT when using JWK set)
            $jwksResponse = Http::timeout(10)->get('https://appleid.apple.com/auth/keys');
            if (!$jwksResponse->ok()) {
                return [null, false];
            }
            $jwks = $jwksResponse->json();
            $keys = JWK::parseKeySet($jwks);
            $decoded = JWT::decode($idToken, $keys);
            // Convert to array
            $payload = json_decode(json_encode($decoded), true);

            $iss = $payload['iss'] ?? '';
            if ($iss !== 'https://appleid.apple.com') {
                return [null, false];
            }
            $aud = $payload['aud'] ?? null;
            $appleClientId = setting('apple_client_id') ?? setting('apple_service_id');
            if ($appleClientId && $aud !== $appleClientId) {
                return [null, false];
            }
            $emailVerified = filter_var($payload['email_verified'] ?? false, FILTER_VALIDATE_BOOLEAN);
            return [$payload, $emailVerified];
        } catch (Exception $e) {
            return [null, false];
        }
    }
}