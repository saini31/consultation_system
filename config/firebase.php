<?php

return [
    'credentials' => [
        // Provide the path to your Firebase credentials JSON file.
        'file' => env('FIREBASE_CREDENTIALS', storage_path('app/firebase_credentials.json')),
    ],
    'database' => [
        'url' => env('FIREBASE_DATABASE_URL', 'https://your-project-id.firebaseio.com'),
    ],
    'storage' => [
        'bucket' => env('FIREBASE_STORAGE_BUCKET', 'laravel-notifications-81fe2.appspot.com'),
    ],
];
