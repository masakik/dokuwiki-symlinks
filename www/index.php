<?php
include '../config.php';

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'e') $c = headerfooter('e');
    if ($_GET['action'] == 'd') $c = headerfooter('d');
    header('Location:./?ret=' . $c);
    exit;
}

function headerfooter($status = 'e')
{
    if ($status == 'e') {
        $count = ativaLink('header.txt');
        $count += ativaLink('footer.txt');
        $count += ativaLink('template.txt');
    }

    if ($status == 'd') {
        $count = desativaLink('header.txt');
        $count += desativaLink('footer.txt');
        $count += desativaLink('template.txt');
    }

    return $count;
}

function ativaLink($file)
{
    global $path;
    exec('find ' . $path . '/ -name "_' . $file . '" -delete');

    exec('find ' . $path . '/ -name "' . $file . '" ', $output);
    foreach ($output as $f) {
        //echo dirname($f) . "\n";
        //echo $f . "<br />";
        exec('cd ' . dirname($f) . '/ && ln -s ' . $file . ' _' . $file);
    }
    return count($output);
}

function desativaLink($file)
{
    global $path;
    $c = shell_exec('find ' . $path . '/ -name "_' . $file . '" | wc -l');
    exec('find ' . $path . '/ -name "_' . $file . '" -delete');
    return $c;
}

?>
<html>
<body>
<p>
    Gerenciador de links simbólicos para: header, footer, template
</p>
<a href="?action=e">Ativar ou reativar links</a><br/>
<a href="?action=d">Desativar links</a><br/>

</body>
</html>

