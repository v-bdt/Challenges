<?php
$dir  = $_POST['dir']  ?? '.';
$file = $_POST['file'] ?? '';

function formatSize($bytes) {
    $units = ['o', 'Ko', 'Mo', 'Go'];
    $i = 0;
    while ($bytes >= 1024 && $i < count($units) - 1) {
        $bytes /= 1024;
        $i++;
    }
    return round($bytes, 2) . ' ' . $units[$i];
}

function afficherArborescence($chemin, $dirCourant) {
    if (!is_dir($chemin)) return;

    $elements = scandir($chemin);
    echo "<ul>";

    foreach ($elements as $element) {
        if ($element === "." || $element === "..") continue;

        $fullPath = $chemin . "/" . $element;

        if (is_dir($fullPath)) {
            echo "<li>📁 
                <form method='post' style='display:inline'>
                    <input type='hidden' name='dir' value='" . htmlspecialchars($fullPath) . "'>
                    <button type='submit'>$element</button>
                </form>";
            afficherArborescence($fullPath, $dirCourant);
            echo "</li>";
        } else {
            $size = formatSize(filesize($fullPath));
            $date = date("d/m/Y H:i", filemtime($fullPath));
            $perms = substr(sprintf('%o', fileperms($fullPath)), -4);

            echo "<li>📄 
                <form method='post' style='display:inline'>
                    <input type='hidden' name='dir' value='" . htmlspecialchars($chemin) . "'>
                    <input type='hidden' name='file' value='" . htmlspecialchars($element) . "'>
                    <button type='submit'>$element</button>
                </form>
                <span class='info'>($size • $date • $perms)</span>
            </li>";
        }
    }
    echo "</ul>";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Explorateur PHP</title>
<style>
body { font-family: Arial; background: #f4f4f4; padding: 20px; }
ul { list-style: none; padding-left: 20px; }
li { margin: 4px 0; }
button { background: none; border: none; color: #0066cc; cursor: pointer; padding: 0; }
button:hover { text-decoration: underline; }
.info { color: #666; font-size: 0.85em; margin-left: 5px; }
pre { background: #222; color: #eee; padding: 15px; overflow: auto; }
.box { background: white; padding: 15px; border-radius: 6px; }
input[type=text] { width: 300px; }
</style>
</head>

<body>

<div class="box">
<h2>📂 Explorateur</h2>

<!-- Formulaire principal -->
<form method="post">
    <label>Dossier :</label><br>
    <input type="text" name="dir" value="<?= htmlspecialchars($dir) ?>">
    <br><br>

    <label>Fichier :</label><br>
    <input type="text" name="file" value="<?= htmlspecialchars($file) ?>">
    <br><br>

    <button type="submit">🔍 Explorer</button>
</form>

<hr>

<!-- Bouton dossier parent -->
<form method="post">
    <input type="hidden" name="dir" value="<?= htmlspecialchars(dirname($dir)) ?>">
    <button type="submit">⬅ Dossier parent</button>
</form>

<br>

<!-- Arborescence -->
<?php afficherArborescence($dir, $dir); ?>
</div>

<!-- Affichage du fichier -->
<?php
if ($file) {
    $path = rtrim($dir, "/") . "/" . $file;
    if (is_file($path)) {
        echo "<div class='box'>";
        echo "<h3>📄 " . htmlspecialchars($file) . "</h3>";
        echo "<pre>" . htmlspecialchars(file_get_contents($path)) . "</pre>";
        echo "</div>";
    }
}
?>

</body>
</html>