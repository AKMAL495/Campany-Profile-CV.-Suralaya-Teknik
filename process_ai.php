<?php
header('Content-Type: application/json');
include 'koneksi.php';
if (!isset($koneksi) && isset($conn)) { $koneksi = $conn; }

$input = json_decode(file_get_contents('php://input'), true);
$userMessage = isset($input['message']) ? trim(strtolower($input['message'])) : '';

if (empty($userMessage)) {
    echo json_encode(['reply' => 'Pesan tidak boleh kosong.']);
    exit;
}

// 1. Cek pertanyaan umum secara instan (Sangat cepat & aman tanpa timeout)
$reply = "";
if (strpos($userMessage, 'cara pesan') !== false || strpos($userMessage, 'pemesanan') !== false || strpos($userMessage, 'pesan jasa') !== false) {
    $reply = "Untuk memesan layanan Suralaya Teknik, Anda bisa menghubungi kami langsung melalui halaman Kontak, mendatangi kantor kami di Jl. By Pass Ketaping No. 16B, Padang, atau menyampaikan detail kebutuhan AC/MEP Anda melalui chat ini agar tim kami segera menindaklanjuti!";
} elseif (strpos($userMessage, 'halo') !== false || strpos($userMessage, 'hi') !== false || strpos($userMessage, 'hii') !== false || strpos($userMessage, 'pagi') !== false) {
    $reply = "Halo! Ada yang bisa Suralaya Teknik bantu terkait kebutuhan HVAC & MEP (AC, instalasi listrik, perpipaan, dll.) Anda hari ini?";
} elseif (strpos($userMessage, 'lokasi') !== false || strpos($userMessage, 'alamat') !== false) {
    $reply = "Kantor CV. Suralaya Teknik berkedudukan di Kota Padang, beralamat di Jl. By Pass Ketaping No. 16B, RT. 05/RW. 06, Kelurahan Pasar Ambacang, Kecamatan Kuranji.";
}

// Jika cocok dengan kata kunci di atas, langsung berikan respons cepat
if (!empty($reply)) {
    echo json_encode(['reply' => $reply]);
    exit;
}

// 2. Jika pertanyaan spesifik, gunakan Google API dengan timeout yang disesuaikan
$context = "Kamu adalah Suralaya Teknik AI, asisten virtual resmi CV. Suralaya Teknik (HVAC & MEP). Jawablah dengan singkat, ramah, dan profesional dalam bahasa Indonesia.";
$apiKey = "AIzaSyBcUVbecLl30O7AYGexxP25mllsEWR6G0I"; 

$payload = json_encode([
    "contents" => [
        [
            "parts" => [
                ["text" => "$context\n\nPertanyaan: $userMessage"]
            ]
        ]
    ]
]);

$ch = curl_init("https://generativelanguage.googleapis.com/v1beta/models/gemini-3.6-flash:generateContent?key=" . $apiKey);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 8);

$response = curl_exec($ch);
$curlError = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($curlError || $httpCode !== 200) {
    // Fallback otomatis jika jaringan lokal sedang memblokir koneksi ke Google
    echo json_encode(['reply' => 'Terima kasih atas pesan Anda. Untuk konsultasi cepat atau pemesanan layanan HVAC & MEP di Suralaya Teknik, silakan hubungi kontak resmi kami atau kunjungi kantor kami di Jl. By Pass Ketaping No. 16B, Padang.']);
    exit;
}

$responseData = json_decode($response, true);

if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
    $aiReply = $responseData['candidates'][0]['content']['parts'][0]['text'];
    echo json_encode(['reply' => $aiReply]);
} else {
    echo json_encode(['reply' => 'Silakan hubungi tim Suralaya Teknik melalui menu Kontak untuk informasi lebih lanjut.']);
}