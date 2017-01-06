<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Efisiobova\Onedrive\Client;

session_start();

try {
    if (!array_key_exists('onedrive.client.state', $_SESSION)) {
        throw new \Exception('onedrive.client.state undefined in session');
    }

    $onedrive = new Client(array(
        'state' => $_SESSION['onedrive.client.state'],
    ));

    $root    = $onedrive->fetchRoot();
    $objects = $root->fetchObjects();
} catch (\Exception $e) {
    $root    = null;
    $objects = null;
    $status  = sprintf('<p class=bg-danger>Reason: <cite>%s</cite><p>', htmlspecialchars($e->getMessage()));
}
?>
<!DOCTYPE html>
<html lang=en dir=ltr>
    <head>
        <meta charset=utf-8>
        <title>Fetching the OneDrive root – Demonstration of the OneDrive SDK for PHP</title>
        <link rel=stylesheet href=//ajax.aspnetcdn.com/ajax/bootstrap/3.2.0/css/bootstrap.min.css>
        <link rel=stylesheet href=//ajax.aspnetcdn.com/ajax/bootstrap/3.2.0/css/bootstrap-theme.min.css>
        <meta name=viewport content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div class=container>
            <h1>Fetching the OneDrive root</h1>
            <?php if (null !== $status) echo $status ?>
            <?php if (null !== $root && null !== $objects): ?>
            <p>The <code>Client::fetchRoot</code> method returned the root from your OneDrive account.</p>
            <h2>Properties</h2>
            <pre><?php print_r($root->fetchProperties()) ?></pre>
            <h2>Objects</h2>
            <?php if (0 == count($objects)): ?>
            <p>There are no objects in this folder.</p>
            <?php else: ?>
            <table class=table>
                <thead>
                    <th>Type</th>
                    <th>Name</th>
                    <th>Size (bytes)</th>
                    <th>Created</th>
                    <th>Last modified</th>
                    <th>ID</th>
                </thead>
                <tbody>
                    <?php foreach ($objects as $object): ?>
                    <tr>
                        <td><code style="white-space: pre">[<?php echo $object->isFolder() ? 'DIR' : '   ' ?>]</code></td>
                        <td><a href="<?php echo $object->isFolder() ? 'folder' : 'file' ?>.php?id=<?php echo htmlspecialchars($object->getId()) ?>"><?php echo htmlspecialchars($object->getName(), ENT_NOQUOTES) ?></a></td>
                        <td style="text-align: right"><?php echo $object->getSize() ?></td>
                        <td><?php echo gmdate('r', $object->getCreatedTime()) ?></td>
                        <td><?php echo gmdate('r', $object->getUpdatedTime()) ?></td>
                        <td><code><?php echo htmlspecialchars($object->getId()) ?></code></td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <?php endif ?>
            <?php endif ?>
            <p><a href=app.php>Back to the examples</a></p>
        </div>
    </body>
</html>
