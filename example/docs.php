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

    $docs = $onedrive->fetchDocs();
} catch (\Exception $e) {
    $docs   = null;
    $status = sprintf('<p class=bg-danger>Reason: <cite>%s</cite><p>', htmlspecialchars($e->getMessage()));
}
?>
<!DOCTYPE html>
<html lang=en dir=ltr>
    <head>
        <meta charset=utf-8>
        <title>Fetching the OneDrive documents – Demonstration of the OneDrive SDK for PHP</title>
        <link rel=stylesheet href=//ajax.aspnetcdn.com/ajax/bootstrap/3.2.0/css/bootstrap.min.css>
        <link rel=stylesheet href=//ajax.aspnetcdn.com/ajax/bootstrap/3.2.0/css/bootstrap-theme.min.css>
        <meta name=viewport content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div class=container>
            <h1>Fetching the OneDrive documents</h1>
            <?php if (null !== $status) echo $status ?>
            <?php if (null !== $docs): ?>
            <p>The <code>Client::fetchDocs</code> method returned:</p>
            <pre><?php print_r($docs) ?></pre>
            <?php endif ?>
            <p><a href=app.php>Back to the examples</a></p>
        </div>
    </body>
</html>
