<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $stripe_public_key, $stripe_secret_key, $socket_url, $options;

    public function __construct()
    {
        $this->stripe_public_key  = '';
        $this->stripe_secret_key  = '';

        // $this->socket_url = 'http://localhost:3000';
        $this->socket_url = '';
        $this->options = [
            'context' => [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false
                ]
            ]
        ];
    }
}
