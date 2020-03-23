<?php

namespace App\Utilities;

class ProxyRequest
{

    /*
    grantPasswordToken - not much happens in this method, 
    we are just setting the parameters needed for Passport 
    "password grant" and make POST request.
    */
    public function grantPasswordToken(string $email, string $password)
    {
        $params = [
            'grant_type' => 'password',
            'username' => $email,
            'password' => $password,
        ];

        return $this->makePostRequest($params);
    }

    /*
    refreshAccessToken - we are checking if the request 
    contains refresh_token if it does we are setting the 
    parameters for refreshing the token and make POST 
    request, if the refresh_token does not exist we abort 
    with 403 status.
    */
    public function refreshAccessToken()
    {
        $refreshToken = request()->cookie('refresh_token');

        abort_unless($refreshToken, 403, 'Your refresh token is expired.');

        $params = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
        ];

        return $this->makePostRequest($params);
    }

    /*
    makePostRequest - this is the key method of this class.
    - We are setting client_id and client_secret from the 
        config, and we are merging additional parameters that 
        are passed as argument
    - Then we are making internal POST request to the Passport 
        routes with the needed parameters
    - We are json decoding the response
    - Set the httponly cookie with refresh_token
    - Return the response


    */

    protected function makePostRequest(array $params)
    {
        $params = array_merge([
            'client_id' => config('services.passport.password_client_id'),
            'client_secret' => config('services.passport.password_client_secret'),
            'scope' => '*',
        ], $params);

        $proxy = \Request::create('oauth/token', 'post', $params);
        $resp = json_decode(app()->handle($proxy)->getContent());

        $this->setHttpOnlyCookie($resp->refresh_token);

        return $resp;
    }

    /*
    setHttpOnlyCookie - set the httponly cookie with 
    refresh_token in the response.
     */

    protected function setHttpOnlyCookie(string $refreshToken)
    {
        cookie()->queue(
            'refresh_token',
            $refreshToken,
            14400, // 10 days
            null,
            null,
            false,
            true // httponly
        );
    }
}
