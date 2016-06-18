<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>KNW2</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<?php
//CreateXMLFileWithVariables();
if(isset($_GET['button']))
{
    if($_GET['button'] == 'stream')
    {
        shell_exec('/var/www/html/Script/start_stream');
        $xml = GetXML();
        $xml->Stream = 'true';
        $xml->Motion = 'false';
        SaveXML($xml);
    }
    else if($_GET['button'] == 'motion')
    {
        shell_exec('/var/www/html/Script/start_motion');
        $xml = GetXML();
        $xml->Stream = 'false';
        $xml->Motion = 'true';
        SaveXML($xml);
    }
    else if($_GET['button'] == 'aus')
    {
        shell_exec('/var/www/html/Script/stop');
        $xml = GetXML();
        $xml->Stream = 'false';
        $xml->Motion = 'false';
        SaveXML($xml);
    }
}
?>

<div id="wrapper">

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <form action="index.php" method="get">
                    <?php
                    $xml = GetXML();
                    if($xml->Stream == 'false')
                    {
                        echo'<input class="btn" style="width: 170px" type="submit" value="stream" name="button">';
                    }
                    elseif($xml->Stream == 'true')
                    {
                        echo'<input class="btn" style="width: 170px" type="submit" value="stream" name="button" disabled>';
                    }
                    ?>
                </form>
            </li>
            <li class="sidebar-brand">
                <form action="index.php" method="get">
                    <?php
                    $xml = GetXML();
                    if($xml->Motion == 'false')
                    {
                        echo'<input class="btn" style="width: 170px" type="submit" value="motion" name="button">';
                    }
                    elseif($xml->Motion == 'true')
                    {
                        echo'<input class="btn" style="width: 170px" type="submit" value="motion" name="button" disabled>';
                    }
                    ?>
                </form>
            </li>
            <li class="sidebar-brand">
                <form action="index.php" method="get">
                    <input class="btn" style="width: 170px" type="submit" value="aus" name="button">
                </form>
            </li>
            <li class="sidebar-brand">
                <a href="archiv.php">Archiv</a>
            </li>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <?php
                    $xml = GetXML();
                    if($xml->Stream == 'false')
                    {
                        echo'<h1>Wilkommen</h1>';
                    }
                    elseif($xml->Motion == 'false')
                    {
                        echo'<h1>Wilkommen</h1>';
                    }

                    if(isset($_GET['button']))
                    {
                        if($_GET['button'] == 'stream')
                        {
                            echo '<h1>Raspberry Pi Cam Stream</h1>';
                            echo '<iframe src="http://10.142.126.116:8554/stream" width="680" height="520" ></iframe>';
                        }
                        elseif($_GET['button'] == 'motion')
                        {
                            echo '<h1>Motion gestartet</h1>';
                            echo '<img src="Alternativ/poster.jpg" width="680" height="350" >';
                        }
                        else if($_GET['button'] == 'aus')
                        {
                            echo '<h1>Stream und Motion gestoppt.</h1>';
                            echo '<h2>Hier ein Video als Zeit vertreib.</h2>';
                            echo '<video src= Alternativ/gentlemenschoice%20-%20BFggwrTCWQQ.mp4 controls>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Menu Toggle Script -->
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>

</body>
<?php
function CreateXMLFileWithVariables()
{
    $dom = new DOMDocument('1.0','UTF-8');
    $root = $dom->appendChild($dom->createElement('Variablen'));
    $Stream = $dom->createElement('Stream','false');
    $Motion = $dom->createElement('Motion','false');
    $root->appendChild($Stream);
    $root->appendChild($Motion);
    $dom->formatOutput = true;
    $dom->save('Values.xml');
}

function GetXML()
{
    $xml = simplexml_load_file('Values.xml');

    return $xml;
}

function SaveXML($xml)
{
    $dom_xml = dom_import_simplexml($xml);
    $dom = new DOMDocument('1.0');
    $dom_xml = $dom->importNode($dom_xml, true);
    $dom->appendChild($dom_xml);
    $dom->save('Values.xml');
}
?>
</html>