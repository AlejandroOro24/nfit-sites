<?php

/**
 *   Copyright 2018 Vimeo.
 *
 *   Licensed under the Apache License, Version 2.0 (the "License");
 *   you may not use this file except in compliance with the License.
 *   You may obtain a copy of the License at
 *
 *       http://www.apache.org/licenses/LICENSE-2.0
 *
 *   Unless required by applicable law or agreed to in writing, software
 *   distributed under the License is distributed on an "AS IS" BASIS,
 *   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *   See the License for the specific language governing permissions and
 *   limitations under the License.
 */
declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Vimeo Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    */

    'connections' => [

        'global' => [
            'client_id'     => env('GLOBAL_VIMEO_CLIENT_ID', "3df778e936e28690114bec2845a7660f42ab0605"),
            'client_secret' => env('GLOBAL_VIMEO_CLIENT_SECRET', "kUQVe9yw/tH81Jtv4S7fpVFoied6b4njylqwpHzi6qWo9V96d8Pn7XNfbVWJ/cGcPlinXX63ck8iAUxgjbqgogDNBzwoizRisEyKb57MAXNozl56V0dF3v9VuuLZ1rAX"),
            'access_token'  => env('GLOBAL_VIMEO_ACCESS_TOKEN', "fe6047c81f7fb95716126fdfc0d49a07"),
        ],
        'alternative' => [
            'client_id' => env('VIMEO_ALT_CLIENT', 'your-alt-client-id'),
            'client_secret' => env('VIMEO_ALT_SECRET', 'your-alt-client-secret'),
            'access_token' => env('VIMEO_ALT_ACCESS', null),
        ],

    ],

];
