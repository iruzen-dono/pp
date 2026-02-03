<?php
// check_images_display.php
// Vérifie que pour chaque produit, l'image référencée existe et est un fichier image valide

declare(strict_types=1);

chdir(__DIR__ . '/..');
$env = require __DIR__ . '/../App/Config/env.php';
$dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $env['db_host'], $env['db_name']);
try {
    $pdo = new PDO($dsn, $env['db_user'], $env['db_pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    echo "DB connection failed: " . $e->getMessage() . PHP_EOL;
    exit(1);
}

$products = $pdo->query("SELECT id, name, image_url FROM products ORDER BY id")->fetchAll();
$report = [];
$ok = 0; $missing = 0; $invalid = 0;

$publicRoot = __DIR__ . '/../Public';

foreach ($products as $p) {
    $id = $p['id'];
    $name = $p['name'];
    $img = $p['image_url'] ?? '';
    $row = ['id' => $id, 'name' => $name, 'image_url' => $img, 'status' => '', 'details' => ''];

    if (empty($img)) {
        $row['status'] = 'MISSING_URL';
        $row['details'] = 'image_url empty';
        $missing++;
        $report[] = $row;
        continue;
    }

    // Convert URL to filesystem path
    $path = $publicRoot . $img;
    if (!file_exists($path)) {
        $row['status'] = 'FILE_NOT_FOUND';
        $row['details'] = $path;
        $missing++;
        $report[] = $row;
        continue;
    }

    if (!is_file($path) || filesize($path) === 0) {
        $row['status'] = 'INVALID_FILE';
        $row['details'] = 'not a regular file or zero bytes';
        $invalid++;
        $report[] = $row;
        continue;
    }

    $info = @getimagesize($path);
    if ($info === false || empty($info['mime']) || strpos($info['mime'], 'image/') !== 0) {
        $row['status'] = 'NOT_IMAGE';
        $row['details'] = 'getimagesize failed or mime not image';
        $invalid++;
        $report[] = $row;
        continue;
    }

    $row['status'] = 'OK';
    $row['details'] = $info['mime'] . ' ' . $info[0] . 'x' . $info[1];
    $ok++;
    $report[] = $row;
}

$csv = __DIR__ . '/image_check_report.csv';
$fh = fopen($csv, 'w');
fputcsv($fh, ['id','name','image_url','status','details']);
foreach ($report as $r) { fputcsv($fh, [$r['id'],$r['name'],$r['image_url'],$r['status'],$r['details']]); }
fclose($fh);

echo "Checked: " . count($products) . " products\n";
echo "OK: $ok, Missing/Not Found: $missing, Invalid Images: $invalid\n";
echo "Report: $csv\n";

if ($missing + $invalid > 0) {
    echo "Some issues detected. Open the report and decide rollback if needed.\n";
} else {
    echo "All images present and valid.\n";
}

?>
