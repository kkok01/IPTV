<?php

$id = $_GET["id"] ?? "HFib76ySpbU"; // Default ID

function get_data($url) {
    $cookies = 'cookies自己抓'; // youtube cookies here

    $ch = curl_init();
    $User_Agent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36";
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_COOKIE, $cookies); // Set the cookies
    curl_setopt($ch, CURLOPT_USERAGENT, $User_Agent); // Set the user_agent

    $data = curl_exec($ch);

    if (curl_errno($ch)) {
        return false; // If there's an error, return false
    }

    curl_close($ch);
    return $data;
}

// Get the YouTube page content
$pageContent = get_data('https://www.youtube.com/watch?v=' . $id);

if ($pageContent === false) {
    echo "Failed to fetch YouTube page.";
    exit;
}

// Decode JSON and ensure proper unescaping
$pageContent = str_replace('\u0026', '&', $pageContent);

if (preg_match('/"hlsManifestUrl":"(.*?)"/', $pageContent, $matches)) {
    $rawURL = htmlspecialchars_decode($matches[1]);

    // Fetch the m3u8 playlist content
    $m3u8_content = @file_get_contents($rawURL);

    if ($m3u8_content === false) {
        echo "Failed to fetch m3u8 content.";
        exit;
    }

    // Match all the stream information
    preg_match_all('/#EXT-X-STREAM-INF:(.*)\n(https?:\/\/[^\s]+)/', $m3u8_content, $matches);

    // Find the 1920x1080 resolution stream
    $selected_stream_url = '';
    foreach ($matches[1] as $index => $stream_info) {
        if (strpos($stream_info, 'RESOLUTION=1920x1080') !== false) {
            // Get the corresponding URL
            $selected_stream_url = $matches[2][$index];
            break;
        }
    }

    // If a stream was found, redirect to it
    if (!empty($selected_stream_url)) {
        header('Location: ' . $selected_stream_url);
        exit;
    } else {
        echo "1080p stream not found.";
    }

} else {
    echo "HLS manifest URL not found.";
}

?>
