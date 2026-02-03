<?php
// generate_mappings_preview.php
// Read scripts/proposed_mappings.csv and inject rows into Public/mappings_preview.html

chdir(__DIR__ . '/..');
$csvPath = __DIR__ . '/proposed_mappings.csv';
$tplPath = __DIR__ . '/../Public/mappings_preview.html';
if (!is_file($csvPath)) { echo "Missing $csvPath\n"; exit(1); }
if (!is_file($tplPath)) { echo "Missing template $tplPath\n"; exit(1); }

$csv = fopen($csvPath, 'r');
$hdr = fgetcsv($csv);
$rowsHtml = '';
while ($r = fgetcsv($csv)) {
    list($id, $name, $old, $file, $new) = $r + array_fill(0,5,'');
    $id = htmlspecialchars($id);
    $name = htmlspecialchars($name);
    $old = htmlspecialchars($old);
    $file = htmlspecialchars($file);
    $new = htmlspecialchars($new);

    $rowsHtml .= "<tr>" .
        "<td><strong>$id</strong><br/>$name</td>" .
        "<td><img src=\"$old\" alt=\"old\"><div>$old</div></td>" .
        "<td>$file</td>" .
        "<td><img src=\"$new\" alt=\"new\"><div>$new</div></td>" .
        "</tr>\n";
}
fclose($csv);

$html = file_get_contents($tplPath);
$html = str_replace('<!-- MAPPINGS_ROWS -->', $rowsHtml, $html);
file_put_contents($tplPath, $html);
echo "Mappings preview generated: Public/mappings_preview.html\n";

?>
