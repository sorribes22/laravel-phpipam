<?php

return [

    /**
     * Can configure multiple connections to different PhpIPAM servers
     */
    'connections' => [
        'default' => [
            /**
             * URL to access to PhpIPAM server
             */
            'url'   => env('PHPIPAM_API_URL'),


            /**
             * App name from PhpIPAM server
             */
            'app'   => env('PHPIPAM_API_APP'),


            /**
             * User from PhpIPAM server
             */
            'user'  => env('PHPIPAM_API_USER'),


            /**
             * Pass from PhpIPAM server
             */
            'pass'  => env('PHPIPAM_API_PASS'),


            /**
             * API KEY to access to PhpIPAM server
             */
            'key'   => env('PHPIPAM_API_KEY')
        ],

        /**
         * Example of multiple connections:
         *
         * 'server2' => [
         *      'url'   => env('PHPIPAM_SERVER2_API_URL'),
         *      'app'   => env('PHPIPAM_SERVER2_API_APP'),
         *      'user'  => env('PHPIPAM_SERVER2_API_USER'),
         *      'pass'  => env('PHPIPAM_SERVER2_API_PASS'),
         *      'key'   => env('PHPIPAM_SERVER2_API_KEY')
         * ]
         *
         */
    ]
];