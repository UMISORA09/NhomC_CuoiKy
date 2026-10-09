<?php
foreach (glob('job-design/*.png') as $f) {
    echo "$f: " . implode('x', getimagesize($f)) . "\n";
}
