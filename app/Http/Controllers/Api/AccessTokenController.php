<?php
namespace App\Http\Controllers\API;

use Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ServerRequestInterface;
use \Laravel\Passport\Http\Controllers\AccessTokenController as ATC;

class AccessTokenController extends ATC
{
    public function login(ServerRequestInterface $request) 
    {
        try { 
            $result = $this->authenticate($request);

            if(isset($result["error"])) {
                return response()->json($result, $result["code"]);
            }

            //generate token
            $tokenResponse = parent::issueToken($request);
            //convert response to json string
            $content = $tokenResponse->getContent();
            
            //convert json to array
            $data = json_decode($content, true);

            if(isset($data["error"]))
                throw new OAuthServerException(config("constants.Messages.IncorrectCredentials"), 6, 'invalid_credentials', 403);

            $result['access_token'] = $data['access_token'];
            $result['expires_in'] = $data['expires_in'];
            $result['refresh_token'] = $data['refresh_token'];

            return Response::json($result);
        }
        catch (ModelNotFoundException $e) { // phone notfound
            //return error message
            $error["error"]=["message" => config("constants.Messages.UserNotFound")];
            $error['code'] =  403;
            return response($error, 403);
        }
        catch (OAuthServerException $e) { //password not correct..token not granted
            //return error message

            $error["error"]=["message" => config("constants.Messages.IncorrectCredentials")];
            $error['code'] =  403; 
            return response($error, 403);
        }
        catch (Exception $e) {
            ////return error message
           
            Log::error('Error: ' . $e->getMessage());

            $error["error"]=["message" => $e->getMessage()];
            $error['code'] =  500;
            return response($error, 500);
        }
    }

    private function authenticate(ServerRequestInterface $request)
    {
        $success = array();

        $error = array();
        $error["success"]= false;
        $error["error"]= [];

        $requestbody = $request->getParsedBody();

        $username = $requestbody["username"];
        $password = $requestbody["password"];

        if (strpos($username, "+62") !== false) {
            $error["error"]=["message" => config("constants.Messages.PhoneNumberWithout62")];
            $error["code"] =  403;
            return $error;
        }

        $user = User::where("phone", "=", $username)->first();

        if(!isset($user["id"])){
                $error["error"]=["message" => config("constants.Messages.UserNotFound")];
                $error["code"] =  403;
                return $error;
        }

        if(!Hash::check($password, $user->password)){
            throw new OAuthServerException(config("constants.Messages.IncorrectCredentials"), 6, "invalid_credentials", 403);
        }

        // remove previous user session
        $userTokens = $user->tokens;
        foreach($userTokens as $token) {
            $token->revoke();
            $token->delete();
        }
        
        $userArray = collect($user);
        unset($userArray["tokens"]);
        $success = $userArray;
        $success["user_id"] = $user["id"];
        return $success;
    }
}
