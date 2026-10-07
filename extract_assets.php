<?php
$source_path = 'job-design/4-all job 2.png';
$im = imagecreatefrompng($source_path);
$out_dir = 'wp-content/themes/jobscout/images/alljobs';
if (!is_dir($out_dir)) {
    mkdir($out_dir, 0777, true);
}

// 1. Hero banner Kyoto background
// Banner is roughly y=80 to y=440, full width 1440
$banner_h = 360;
$banner_w = 1440;
$banner_im = imagecreatetruecolor($banner_w, $banner_h);
imagecopy($banner_im, $im, 0, 0, 0, 80, $banner_w, $banner_h);
imagejpeg($banner_im, $out_dir . '/career-banner.jpg', 90);
imagedestroy($banner_im);
echo "Extracted career-banner.jpg\n";

// 2. Header logo
// Let's locate the header logo at top left: roughly x=90 to 250, y=10 to 75
$logo_w = 200;
$logo_h = 60;
$logo_im = imagecreatetruecolor($logo_w, $logo_h);
imagecopy($logo_im, $im, 0, 0, 85, 10, $logo_w, $logo_h);
imagepng($logo_im, $out_dir . '/logo-recruiting.png');
imagedestroy($logo_im);
echo "Extracted logo-recruiting.png\n";

// 3. Company logos from the cards
// Card 1 logo: around x=115, y=520, w=100, h=100
// Card 2 logo: around x=745, y=520, w=100, h=100
// Card 3 logo: around x=115, y=820, w=100, h=100
// Card 4 logo: around x=745, y=820, w=100, h=100
// Card 5 logo: around x=115, y=1120, w=100, h=100
// Card 6 logo: around x=745, y=1120, w=100, h=100

$companies = [
    ['name' => 'sodoh', 'x' => 115, 'y' => 520, 'w' => 110, 'h' => 100],
    ['name' => 'fortune-garden', 'x' => 745, 'y' => 520, 'w' => 110, 'h' => 100],
    ['name' => 'banquet-logo', 'x' => 115, 'y' => 820, 'w' => 110, 'h' => 100],
    ['name' => 'the-sodoh-house', 'x' => 745, 'y' => 820, 'w' => 110, 'h' => 100],
    ['name' => 'pho-thin', 'x' => 115, 'y' => 1120, 'w' => 110, 'h' => 100],
    ['name' => 'from-where-i-stand', 'x' => 745, 'y' => 1120, 'w' => 110, 'h' => 100],
];

foreach ($companies as $comp) {
    $c_im = imagecreatetruecolor($comp['w'], $comp['h']);
    imagecopy($c_im, $im, 0, 0, $comp['x'], $comp['y'], $comp['w'], $comp['h']);
    imagepng($c_im, $out_dir . '/' . $comp['name'] . '.png');
    imagedestroy($c_im);
    echo "Extracted " . $comp['name'] . ".png\n";
}

// 4. Footer logo (around center x=600..840, y=2540..2600)
$f_logo_im = imagecreatetruecolor(220, 50);
imagecopy($f_logo_im, $im, 0, 0, 610, 2545, 220, 50);
imagepng($f_logo_im, $out_dir . '/footer-logo.png');
imagedestroy($f_logo_im);
echo "Extracted footer-logo.png\n";

imagedestroy($im);
echo "Extraction completed successfully!\n";
