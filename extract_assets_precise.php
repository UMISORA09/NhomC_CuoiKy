<?php
$source_path = 'job-design/4-all job 2.png';
$im = imagecreatefrompng($source_path);
$out_dir = 'wp-content/themes/jobscout/images/alljobs';
if (!is_dir($out_dir)) {
    mkdir($out_dir, 0777, true);
}

// 1. Header logo: Plan Do See Recruiting (top left)
// bbox: x=[53..354], y=[20..63]
$w = 304; $h = 46;
$h_logo = imagecreatetruecolor($w, $h);
imagecopy($h_logo, $im, 0, 0, 52, 19, $w, $h);
imagepng($h_logo, $out_dir . '/logo-recruiting.png');
imagedestroy($h_logo);
echo "Extracted logo-recruiting.png\n";

// 2. Hero banner Kyoto
$banner = imagecreatetruecolor(1440, 356);
imagecopy($banner, $im, 0, 0, 0, 86, 1440, 356);
imagejpeg($banner, $out_dir . '/career-banner.jpg', 95);
imagedestroy($banner);
echo "Extracted career-banner.jpg\n";

// 3. The 6 Company Logos
// Square boxes of size 120x120
$logos = [
    'sodoh' => [220, 517, 120, 120],
    'fortune-garden' => [760, 517, 120, 120],
    'banquet-logo' => [220, 785, 120, 120],
    'the-seven-house' => [760, 785, 120, 120],
    'pho-thin' => [220, 1055, 120, 120],
    'from-where-i-stand' => [760, 1055, 120, 120],
];

foreach ($logos as $name => $coord) {
    $box = imagecreatetruecolor($coord[2], $coord[3]);
    imagecopy($box, $im, 0, 0, $coord[0], $coord[1], $coord[2], $coord[3]);
    imagepng($box, $out_dir . '/' . $name . '.png');
    imagedestroy($box);
    echo "Extracted {$name}.png\n";
}

// 4. Footer Logo (center)
// bbox: x=[498..940] y=[2554..2618]
$w = 444; $h = 66;
$f_logo = imagecreatetruecolor($w, $h);
imagecopy($f_logo, $im, 0, 0, 497, 2553, $w, $h);
imagepng($f_logo, $out_dir . '/footer-logo.png');
imagedestroy($f_logo);
echo "Extracted footer-logo.png\n";

imagedestroy($im);
echo "Done!\n";
