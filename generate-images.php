<?php

/**
 * Generate images for Nature Gold using Nano Banana (Gemini API)
 * Usage: php generate-images.php
 */

$apiKey = getenv('GEMINI_API_KEY') ?: die("Set GEMINI_API_KEY env variable\n");
$model = 'gemini-2.5-flash-image';
$endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

$basePath = __DIR__ . '/storage/app/public';

// All images to generate
$images = [
    // Hero Banners (wide landscape, 1920x800 feel)
    [
        'path' => 'banners/hero-1.jpg',
        'prompt' => 'Professional wide banner image for a premium cold-pressed oil brand called "Nature Gold" from Tamil Nadu, India. Show beautiful golden cold-pressed groundnut oil being poured from a traditional wooden cold-press (chekku/marachekku) into a glass bottle. Include fresh peanuts scattered around. Warm golden and green color palette. Natural farm-to-table feel. Clean, modern food photography style. Wide landscape composition 1920x800. No text overlay.',
    ],
    [
        'path' => 'banners/hero-2.jpg',
        'prompt' => 'Professional wide banner image for an Indian oil brand delivery promotion. Show a delivery box with glass bottles of various cold-pressed oils (golden groundnut oil, amber sesame oil, clear coconut oil) surrounded by natural ingredients like peanuts, sesame seeds, coconuts. Include a small map of Tamil Nadu outline subtly in background. Warm, inviting colors with gold and green tones. Wide landscape composition 1920x800. No text overlay. Clean product photography.',
    ],
    [
        'path' => 'banners/hero-3.jpg',
        'prompt' => 'Professional wide banner image for a dealer/business partnership program for an Indian oil brand. Show a business handshake concept with bottles of cold-pressed oils displayed on elegant shelving in a store setting. Premium, professional look. Gold and deep green color scheme. Tamil Nadu cultural elements subtly in the background. Wide landscape composition 1920x800. No text overlay. Clean commercial photography.',
    ],

    // Category Images (square-ish, product category showcase)
    [
        'path' => 'categories/oils.jpg',
        'prompt' => 'Product category image showing a collection of premium cold-pressed oils in beautiful glass bottles. Include groundnut oil (golden), sesame oil (amber), coconut oil (clear), and mustard oil (yellow). Arranged elegantly on a rustic wooden surface with scattered seeds and nuts. Warm lighting, white/cream background. Square composition. Professional food photography. No text.',
    ],
    [
        'path' => 'categories/spices.jpg',
        'prompt' => 'Product category image of premium Indian spices. Show vibrant turmeric powder (bright yellow), red chili powder, black pepper, coriander powder arranged in small traditional brass bowls on a dark wooden surface. Fresh turmeric root and whole spices scattered around. Rich warm colors. Square composition. Professional food photography. No text.',
    ],
    [
        'path' => 'categories/seeds.jpg',
        'prompt' => 'Product category image of premium natural seeds. Show white sesame seeds, flax seeds, pumpkin seeds, sunflower seeds in small glass jars and wooden bowls on a clean light surface. Fresh, natural, healthy feel. Bright natural lighting. Square composition. Professional food photography. No text.',
    ],
    [
        'path' => 'categories/honey.jpg',
        'prompt' => 'Product category image of natural honey and traditional Indian food products. Show golden honey in a glass jar with honeycomb, along with jaggery (palm sugar), raw sugar. Natural wooden background with leaves. Warm golden tones. Square composition. Professional food photography. No text.',
    ],
    [
        'path' => 'categories/groundnut-oil.jpg',
        'prompt' => 'Product category image of premium cold-pressed groundnut oil. A beautiful glass bottle of golden groundnut oil with fresh raw peanuts in shells and shelled peanuts scattered around. Traditional wooden cold-press element in background. Warm golden lighting on cream background. Square composition. Professional product photography. No text.',
    ],
    [
        'path' => 'categories/sesame-oil.jpg',
        'prompt' => 'Product category image of premium cold-pressed sesame oil (gingelly oil). A glass bottle of rich amber sesame oil with white and black sesame seeds scattered on a wooden surface. Traditional Indian oil extraction feel. Warm amber tones. Square composition. Professional product photography. No text.',
    ],
    [
        'path' => 'categories/coconut-oil.jpg',
        'prompt' => 'Product category image of pure virgin coconut oil. A glass jar of crystal-clear coconut oil with fresh halved coconut, coconut flakes, and a whole coconut. Tropical green leaves as accent. Clean white background with natural lighting. Square composition. Professional product photography. No text.',
    ],

    // Product Images
    [
        'path' => 'products/groundnut-oil-1.jpg',
        'prompt' => 'Professional product photography of a premium cold-pressed groundnut oil bottle. Elegant glass bottle with a gold and green label (label should say "Nature Gold"). Golden colored oil visible through glass. Surrounded by fresh raw peanuts in shells. Clean white/cream studio background. Studio lighting with soft shadows. Professional ecommerce product photo style. High quality.',
    ],
    [
        'path' => 'products/sesame-oil-1.jpg',
        'prompt' => 'Professional product photography of a premium cold-pressed sesame oil (gingelly oil/nallennai) bottle. Elegant glass bottle with gold and green label (label should say "Nature Gold"). Rich amber-colored oil visible through glass. White and black sesame seeds scattered at base. Clean white/cream studio background. Studio lighting. Professional ecommerce product photo. High quality.',
    ],
    [
        'path' => 'products/coconut-oil-1.jpg',
        'prompt' => 'Professional product photography of a premium virgin coconut oil jar. Wide-mouth glass jar with gold and green label (label should say "Nature Gold"). Clear/white coconut oil visible. Half coconut and coconut pieces at base. Clean white/cream studio background. Studio lighting with soft shadows. Professional ecommerce product photo. High quality.',
    ],
    [
        'path' => 'products/mustard-oil-1.jpg',
        'prompt' => 'Professional product photography of a premium cold-pressed mustard oil bottle. Glass bottle with gold and green label (label should say "Nature Gold"). Yellow-tinted mustard oil visible through glass. Yellow mustard seeds and mustard flowers at base. Clean white/cream studio background. Studio lighting. Professional ecommerce product photo. High quality.',
    ],
    [
        'path' => 'products/turmeric-1.jpg',
        'prompt' => 'Professional product photography of premium turmeric powder in an elegant container/pouch. Gold and green branded packaging (brand "Nature Gold"). Vibrant bright yellow turmeric powder spilling slightly. Fresh turmeric roots beside the pack. Clean white/cream studio background. Studio lighting. Professional ecommerce product photo. High quality.',
    ],
    [
        'path' => 'products/sesame-seeds-1.jpg',
        'prompt' => 'Professional product photography of premium white sesame seeds in an elegant package/pouch. Gold and green branded packaging (brand "Nature Gold"). White sesame seeds scattered around the package. Clean white/cream studio background. Studio lighting with soft shadows. Professional ecommerce product photo. High quality.',
    ],
];

echo "Starting image generation with Nano Banana...\n";
echo "Total images to generate: " . count($images) . "\n\n";

$success = 0;
$failed = 0;

foreach ($images as $i => $img) {
    $num = $i + 1;
    $total = count($images);
    echo "[{$num}/{$total}] Generating: {$img['path']}... ";

    $fullPath = $basePath . '/' . $img['path'];
    $dir = dirname($fullPath);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    $payload = json_encode([
        'contents' => [
            [
                'parts' => [
                    ['text' => $img['prompt']],
                ],
            ],
        ],
        'generationConfig' => [
            'responseModalities' => ['image', 'text'],
        ],
    ]);

    $ch = curl_init($endpoint);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 120,
        CURLOPT_CAINFO => '/etc/ssl/cert.pem',
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($curlError) {
        echo "CURL ERROR: {$curlError}\n";
        $failed++;
        continue;
    }

    if ($httpCode !== 200) {
        $errorData = json_decode($response, true);
        $errorMsg = $errorData['error']['message'] ?? "HTTP {$httpCode}";
        echo "API ERROR: {$errorMsg}\n";
        $failed++;
        // Wait before retry on rate limit
        if ($httpCode === 429) {
            echo "   Rate limited. Waiting 30 seconds...\n";
            sleep(30);
        }
        continue;
    }

    $data = json_decode($response, true);

    // Extract image data from response
    $imageData = null;
    if (isset($data['candidates'][0]['content']['parts'])) {
        foreach ($data['candidates'][0]['content']['parts'] as $part) {
            if (isset($part['inlineData'])) {
                $imageData = base64_decode($part['inlineData']['data']);
                break;
            }
        }
    }

    if ($imageData) {
        file_put_contents($fullPath, $imageData);
        $size = round(strlen($imageData) / 1024);
        echo "OK ({$size} KB)\n";
        $success++;
    } else {
        echo "NO IMAGE IN RESPONSE\n";
        // Log the response for debugging
        file_put_contents($fullPath . '.error.json', $response);
        $failed++;
    }

    // Small delay between requests to avoid rate limiting
    if ($i < count($images) - 1) {
        sleep(3);
    }
}

echo "\n========================================\n";
echo "Done! Success: {$success} | Failed: {$failed}\n";
echo "========================================\n";
