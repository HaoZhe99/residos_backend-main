<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\SMS;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Client;
// require __DIR__ . '/vendor/autoload.php';

class UsersApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserResource(User::with(['roles'])->get());
    }

    public function store(StoreUserRequest $request)
    {

        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        if ($request->input('profile_image', false)) {
            $user->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile_image'))))->toMediaCollection('profile_image');
        }

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserResource($user->load(['roles']));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        if ($request->input('profile_image', false)) {
            if (!$user->profile_image || $request->input('profile_image') !== $user->profile_image->file_name) {
                if ($user->profile_image) {
                    $user->profile_image->delete();
                }

                $user->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile_image'))))->toMediaCollection('profile_image');
            }
        } elseif ($user->profile_image) {
            $user->profile_image->delete();
        }

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function login($email)
    {
        $user = User::with(['roles'])->where('email', $email)->first();

        return new UserResource($user);
    }

    public function updateProfile(Request $request, User $user)
    {
        $user->update([
            'name'           => $request->name,
            'contact_number' => $request->contact_number,
        ]);

        if ($request->file('profile_image', false)) {
            if (!$user->profile_image || $request->file('profile_image') !== $user->profile_image->file_name) {
                if ($user->profile_image) {
                    $user->profile_image->delete();
                }

                $user->addMedia(/*storage_path('tmp/uploads/' . */$request->file('profile_image')/*)*/)->toMediaCollection('profile_image');
            }
            // } elseif ($user->avatar) {
            //     $user->avatar->delete();
        }

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function addUser(Request $request)
    {
        $contact_number = ($request->has('country_num'))
            ? Str::replaceFirst('0', '', $request->country_num) . '' . $request->contact_number
            : $request->contact_number;

        $user = User::where('contact_number', $contact_number)->first();

        if ($user == null) {
            $user = User::create([
                'name'           => $request->name,
                'ic_number'      => $request->ic_number,
                'contact_number' => $contact_number,
            ]);
            $user->roles()->sync($request->input('roles', []));

            return (new UserResource($user))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
        }

        return (new UserResource($user));
    }

    public function store_contact_number(Request $request)
    {
        $user = User::create([
            'contact_number' => '+6' . $request->contact_number,
        ]);
        $user->roles()->sync($request->input('roles', []));

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function getVerify(Request $request)
    {
        $contact_number = ($request->has('country_num'))
            ? Str::replaceFirst('0', '', '+' . $request->country_num) . '' . $request->contact_number
            : $request->contact_number;
        // dd($contact_number);

        $user = User::where('contact_number', $contact_number)->first();
        // dd($user);

        if ($user != null && $user->verified == 0) {
            $token     = mt_rand(100000, 999999);
            $usedToken = User::where('verification_token', $token)->first();

            while ($usedToken) {
                $token     = mt_rand(100000, 999999);
                $usedToken = User::where('verification_token', $token)->first();
            }

            $user->verification_token = $token;
            $user->save();

            $sms = SMS::first();

            $response = Http::get('https://sendsms.asia/api/v1/send/sms', [
                'username' => $sms->username,
                'secret_key' => $sms->secret_key,
                'phone' =>  $user->contact_number,
                'content' => 'Your verification code is: ' . $user->verification_token,
            ]);

            // Your Account SID and Auth Token from twilio.com/console
            // $sid    = 'AC44dda61eb3b1b525f6f4b6914ac2d80a'; //'ACf6cb5bb2dc927fc699bb1dfe640c44c0'; //'ACb4a44bb3b51fa5085441b7730248d5ae';
            // $token  = 'a35226b7dd2a7eda39081af82ddbff41'; //'30cde6ebd3d944a0422dbe9752a5640d'; //'ed921e66788e02398c8f4088c34d5d60';
            // $client = new Client($sid, $token);

            // Use the client to do fun stuff like send text messages!
            // $client->messages->create(  
            //     // the number you'd like to send the message to
            //     $user->contact_number, //'+601139979084',
            //     [
            //         // A Twilio phone number you purchased at twilio.com/console
            //         'from' => '+18577633059', //'+13143473050', //'+12489654227',
            //         // the body of the text message you'd like to send
            //         'body' => 'Your verification code is: ' . $user->verification_token //'Hey Jenny! Good luck on the bar exam!'
            //     ]
            // );

            return new UserResource($user);
        }

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_NOT_FOUND);
    }

    public function verifying(Request $request)
    {
        $contact_number = ($request->has('country_num'))
            ? Str::replaceFirst('0', '', '+' . $request->country_num) . '' . $request->contact_number
            : $request->contact_number;

        $user = User::where('contact_number', $contact_number)
            ->where('verification_token', $request->verification_token)
            ->first();

        if ($user != null && $user->verified == 0) {
            $user->verification_token = null;
            $user->verified           = 1;
            $user->verified_at        = Carbon::now()->format(config('panel.date_format') . ' ' . config('panel.time_format'));
            $user->save();

            return new UserResource($user);
        }

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_NOT_FOUND);
    }

    public function register(Request $request)
    {
        $contact_number = ($request->has('country_num'))
            ? Str::replaceFirst('0', '', '+' . $request->country_num) . '' . $request->contact_number
            : $request->contact_number;

        $user = User::where('contact_number', $contact_number)->first();
        // dd($user);

        if ($user != null && $user->username == null && $user->verified == 1) {
            // dd('hi');
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255', 'unique:users'],
                'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            if ($validator->fails()) {
                // dd('hi');
                $user = $validator->messages();
                return (new UserResource($user))
                    ->response()
                    ->setStatusCode(Response::HTTP_BAD_REQUEST);
            } else {
                // dd('hi');
                $user->update([
                    'contact_number' => $request->contact_number,
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $request->password,
                ]);
                // $user->roles()->sync($request->input('roles', []));
                return new UserResource($user);
            }
        }

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_NOT_FOUND);
    }

    public function registerApi(Request $request)
    {
        $user = User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => $request->password,
            'contact_number' => $request->contact_number,
        ]);
        $user->roles()->sync($request->input('roles', []));

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_NOT_FOUND);
    }
}
