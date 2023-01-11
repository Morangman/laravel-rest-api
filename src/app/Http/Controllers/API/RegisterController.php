<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\RegisterRequest;
use App\Models\AccessToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterController extends BaseController
{
    public function getToken()
    {
        $token = hash('sha256', Str::random(40) . time());

        AccessToken::query()->create([
            'token' => $token
        ]);

        $response = [
            'success' => true,
            'token' => $token,
        ];
        
        return response()->json($response, 200);
    }

    public function register(RegisterRequest $request)
    {
        $token = $request->header('Token');

        if ($token && ($token = AccessToken::query()->where('token', $token)->first())) {
            $expired = $token->created_at->addMinutes(40);

            if (Carbon::now() > $expired) {
                $token->delete();

                return $this->sendError('The token expired.', [], 401);
            }
        } else {
            return $this->sendError('The token expired.', [], 401);
        }

        if (User::query()->where('email', $request->get('email'))->orWhere('phone', $request->get('phone'))->exists()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'User with this phone or email already exist',
            ], 409));
        }
        
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $path = $request->photo->path();

        $name = rand() . time();

        \Tinify\setKey(env('TINIFY_APIKEY'));

        $source = \Tinify\fromFile($path);
        
        $resized = $source->resize([
            "method" => "cover",
            "width" => 70,
            "height" => 70,
        ]);

        $converted = $resized->convert(["type" => "image/jpeg"]);

        $image_name = "$name.jpg";
        
        $converted->toFile(public_path() . '/media/' . $image_name);

        $input['photo'] = "/media/$image_name";

        $user = User::create($input);

        $token->delete();
        
        $response = [
            'success' => true,
            'user_id' => $user->id,
            'message' => 'New user successfully registered',
        ];
        
        return response()->json($response, 200);
    }
}