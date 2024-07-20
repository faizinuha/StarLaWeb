<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $message = $data['message'];

    $apiKey = 'your_openai_api_key_here';  // Ganti dengan API key Anda
    $apiUrl = 'https://api.openai.com/v1/chat/completions';

    $headers = [
        'Content-Type: application/json',
        'Authorization: ' . 'Bearer ' . $apiKey,
    ];

    $postData = json_encode([
        'model' => 'gpt-4',  // Gunakan model yang sesuai
        'messages' => [
            ['role' => 'user', 'content' => $message],
        ],
        'max_tokens' => 150,
    ]);

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    $response = curl_exec($ch);
    curl_close($ch);

    $responseBody = json_decode($response, true);
    $reply = $responseBody['choices'][0]['message']['content'] ?? 'Sorry, I could not process your request.';

    echo json_encode(['reply' => $reply]);
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
