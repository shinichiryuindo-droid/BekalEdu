<?php

define('GEMINI_API_KEY', 'AQ.Ab8RN6JS8f8yXBJRCKHCWDtH2ersYl0AaFQSF_UQ1RrRZS78FQ');

$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . GEMINI_API_KEY;

$body = [
    "contents" => [
        [
            "parts" => [
                [
                    "text" => "Search the web and tell me the latest scholarships in Indonesia that are still open. in 2026"
                ]
            ]
        ]
    ],
    "tools" => [
        [
            "google_search" => new stdClass()
        ]
    ]
];

$ch = curl_init($url);

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json"
    ],
    CURLOPT_POSTFIELDS => json_encode($body)
]);

$response = curl_exec($ch);

if ($response === false) {
    die("cURL Error: " . curl_errno($ch) . " - " . curl_error($ch));
}

$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

echo "<h3>HTTP Status: $http</h3>";

echo "<pre>";
print_r(json_decode($response, true));
echo "</pre>";