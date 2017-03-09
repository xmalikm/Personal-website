<?php
/**
 * Maly PHP skript na odoslanie mailu pri vyplneni formularu v sekcii "Kontakt"
 */

// inicializacia premennych
$nameErr = $emailErr = $messageErr = "";    // error messages
$name = $email = $message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // meno
    if (empty($_POST["name"])) {
        $nameErr = "Nezadali ste meno!";
    } else {
        $name = testInput($_POST["name"]);
        // kontrola ci meno obsahuje iba pismena a medzery
        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
            $nameErr = "Meno môže obsahovať iba písmená a medzery!"; 
        }
    }
    // e-mail
    if (empty($_POST["email"])) {
        $emailErr = "Nezadali ste e-mail!";
    } else {
        $email = testInput($_POST["email"]);
        // kontrola formatu e-mailu
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "E-mail je v nesprávnom tvare!"; 
        }
    }
    // sprava
    if (empty($_POST["message"])) {
        $messageErr = "Nezadali ste správu!";
    } else {
        $message = testInput($_POST["message"]);
    } 

    // ak su inputy spravne, pokusime sa odoslat e-mail
    if(empty($nameErr) && empty($emailErr) && empty($messageErr)) {
        date_default_timezone_set('Etc/UTC');
        require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
        // instancia PHPMailer-u
        $mail = new PHPMailer;
        
        $mail->CharSet = 'UTF-8';
        // pouzitie SMTP
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = 'your host';
        $mail->Port = 25;
        $mail->Username = 'your username';
        $mail->Password = 'your password';
        // pevna adresa nastavena ako adresa odosielatela
        $mail->setFrom('from@example.com', 'MalikWeb');
        // moja adresa ako adresa prijemcu
        $mail->addAddress('add@example.com', 'Martin Malik');
        // reply-to adresa
        $mail->addReplyTo($_POST['email'], $_POST['name']);
        $mail->Subject = 'MalikWeb kontaktný formulár';
        // nepouzivanie HTML
        $mail->isHTML(false);
        // telo spravy
        $mail->Body = <<<EOT
Email: {$_POST['email']}
Name: {$_POST['name']}
Message: {$_POST['message']}
EOT;
        if (!$mail->send()) {
            $msg = 'Prepáčte, niekde nastala chyba';
        } else {
            $msg = 'Ďakujem, vaša správa bola odoslaná';
        }
    }
}

/**
 *    Funkcia na overenie inputu z kontakt formularu
 */
function testInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);

  return $data;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Martin Malik</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- favicony -->
  <link rel="apple-touch-icon" sizes="180x180" href="/../files/favicons/apple-touch-icon.png">
  <link rel="icon" type="image/png" href="/../files/favicons/favicon-32x32.png" sizes="32x32">
  <link rel="icon" type="image/png" href="/../files/favicons/favicon-16x16.png" sizes="16x16">
  <link rel="manifest" href="/../files/favicons/manifest.json">
  <link rel="mask-icon" href="/../files/favicons/safari-pinned-tab.svg" color="#5bbad5">
  <link rel="shortcut icon" href="/../files/favicons/favicon.ico">
  <meta name="msapplication-config" content="/about/favicons/browserconfig.xml">
  <meta name="theme-color" content="#ffffff">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body id="about-page" data-spy="scroll" data-target=".navbar" data-offset="60">
    
    <!-- kontajner vo viewporte stranky -->
    <div id="view-container" class="container-fluid container-cover">
        <!-- navigacne menu -->
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <!-- header navbaru + mobile view ikona -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#about-navbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- logo stranky -->
                    <a class="navbar-brand" href="#about-page">
                        <img src="/../files/logos/m&m(white-blue).png" title="M&M logo">
                    </a>
                </div>
                <!-- linky navbaru -->
                <div class="collapse navbar-collapse" id="about-navbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#about">O MNE</a></li>
                        <li><a href="#skills">SKUSENOSTI</a></li>
                        <li><a href="#portfolio">REFERENCIE</a></li>
                        <li><a href="#contact">KONTAKT</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- titulok stranky -->
        <div class="cover-content">
            <!-- prvy podnadpis -->
            <h6>Vitajte volám sa</h6>
            <!-- hlavny nadpis -->
            <h1>Martin Malik</h1>
            <!-- druhy podnadpis -->
            <h3>
                Som web developer, mojou prioritou<br>
                je backend aplikácií ale som stotožnený aj s frontendom<br>
                Programujem v jazyku PHP
            </h3>
        </div><!-- titulok stranky -->
        <a href="#about" class="scroll-icon"></a>
    </div><!-- kontajner vo viewporte stranky -->

    <!-- sekcia - "o mne" -->
    <section class="content-section">
        <!-- kontajner wrapper - uzsi -->
        <div id="about" class="container container-wrapper">

            <div class="row text-center">
                <!-- nadpis sekcie -->
                <h1 class="section-title">Pár slov o mne</h1>
                <!-- vyclearovanie dalsieho contentu -->
                <div class="clear-content"></div>
                <!-- foto "o mne" -->
                <div class="content-align-vertical">
                    <div class="col-sm-6">
                        <img class="img-thumbnail img-responsive" src="images/me_beach.png">
                    </div>
                    <!-- text "o mne" -->
                    <div class="col-sm-6 slide-anim-left">
                        <h4 class="text">
                            Som 23-ročný junior <strong>PHP programátor</strong> webových stránok. Pochádzam z Nitry ale
                            už <?php echo round((strtotime(date('M j, Y H:i:s'))-strtotime('Sep 1, 2013 00:00:00'))/31536000, 0); ?> roky bývam v <strong>Bratislave</strong>.
                            Som študentom Slovenskej technickej univerzity. Študujem odbor <strong>aplikovaná informatika</strong> na fakulte elektrotechniky a informatiky.
                            Programovaniu webu sa intenzívne venujem cca <strong>2 roky</strong>. Od vtedy sa kódenie stalo mojou každodennou súčasťou a zároveň mojim najväščím hobby.
                            Mam rád <strong>čistý</strong>, dobre <strong>okomentovaný</strong> kód, ktorý je jednoduchý, ale zároveň <strong>efektívny</strong>. Mojou prioritou je programovanie v jazyku PHP a teda
                            <strong>backend aplikácií</strong>. Programujem v PHP frameworku <strong>Laravel</strong> a pre prácu s databázami ovládam jazyk <strong>SQL</strong>. Samozrejmosťou sú znalosti <strong>HTML</strong> a <strong>CSS</strong>.
                            Na štýlovanie používam <strong>Bootstrap</strong> framework a interakciu stránok vytváram v <strong>jQuery</strong>. Vždy sa snažím robiť stránky <strong>responzívne</strong>, s <strong>mobile first</strong> prístupom. Moje práce si môžte pozrieť v <a href="#portfolio" style="text-decoration: underline;">portfóliu</a>.<br><br>
                            
                            Ak práve neprogramujem, tak sa venujem <strong>frajerke</strong> alebo <strong>športujem</strong>. Milujem <strong>futbal</strong> a rád chodím do fitka a bicyklujem. Takmer stále počúvam <strong>hudbu</strong> a rád si pozriem dobrý <strong>film</strong> alebo seriál.<br><br>

                            Zaujímam sa o <strong>nové technológie</strong> a fascinuje ma učenie sa stále nových a nových vecí. Mám rád výzvy a svoju robotu sa vždy snažím spraviť na 100%.<br><br>

                            Rád <strong>cestujem</strong> a spoznávam nových ľudí.
                        </h4>
                    </div>
                </div>
            </div><!-- row -->

        </div><!-- kontajner wrapper - uzsi -->
    </section><!-- sekcia - "o mne" -->

    <!-- sekcia - "moje skills" -->
    <section class="content-section bg-grey">
        <div id="skills" class="container text-center">

            <!-- nadpis sekcie -->
            <h1 class="section-title">Moje skills</h1>
            <!-- vyclearovanie dalsieho contentu -->
            <div class="clear-content"></div>

            <div class="row">

                <!-- html karta -->
                <div class="skill-card col-sm-4 slide-anim-down">
                    <!-- panel -->
                    <div class="panel panel-default panel-html">
                        <!-- heading panelu -->
                        <div class="panel-heading">
                            <h3>HTML</h3>
                        </div>
                        <!-- telo panelu -->
                        <div class="panel-body">
                            <!-- obrazok -->
                            <img src="logo/html.png">
                            <!-- velkost skillu -->
                            <h4>Pokročilý</h4>
                            <!-- progress bar -->
                            <div class="progress">
                                <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"
                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:75%">
                                    75%
                                </div>
                            </div><!-- progress bar -->
                        </div><!-- telo panelu -->
                    </div><!-- panel -->
                </div><!-- html karta -->

                <!-- css karta -->
                <div class="col-sm-4 skill-card slide-anim-down">
                    <!-- panel -->
                    <div class="panel panel-default panel-css">
                        <!-- heading panelu -->
                        <div class="panel-heading">
                            <h3>CSS</h3>
                        </div>
                        <!-- telo panelu -->
                        <div class="panel-body">
                            <!-- obrazok -->
                            <img src="logo/css.png">
                            <!-- velkost skillu -->
                            <h4>Pokročilý</h4>
                            <!-- progress bar -->
                            <div class="progress">
                                <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"
                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:75%">
                                    75%
                                </div>
                            </div><!-- progress bar -->
                        </div><!-- telo panelu -->
                    </div><!-- panel -->
                </div><!-- css karta -->
                    
                <!-- javascript karta -->
                <div class="col-sm-4 skill-card slide-anim-down">
                    <!-- panel -->
                    <div class="panel panel-default panel-js">
                        <!-- heading panelu -->
                        <div class="panel-heading">
                            <h3>JAVASCRIPT</h3>
                        </div>
                        <!-- telo panelu -->
                        <div class="panel-body">
                            <!-- obrazok -->
                            <img src="logo/js.png">
                            <!-- velkost skillu -->
                            <h4>Mierne pokročilý</h4>
                            <!-- progress bar -->
                            <div class="progress">
                                <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%">
                                    50%
                                </div>
                            </div><!-- progress bar -->
                        </div><!-- telo panelu -->
                    </div><!-- panel -->
                </div><!-- javascript karta -->

            </div><!-- row -->
                    
            <div class="row">

                <!-- php karta -->
                <div class="col-sm-6 skill-card slide-anim-down">
                    <!-- panel -->
                    <div class="panel panel-default panel-php">
                        <!-- heading panelu -->
                        <div class="panel-heading">
                            <h3>PHP</h3>
                        </div>
                        <!-- telo panelu -->
                        <div class="panel-body">
                            <!-- obrazok -->
                            <img src="logo/php.png">
                            <!-- velkost skillu -->
                            <h4>Pokročilý</h4>
                            <!-- progress bar -->
                            <div class="progress">
                                <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"
                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:75%">
                                    75%
                                </div>
                            </div><!-- progress bar -->
                        </div><!-- telo panelu -->
                    </div><!-- panel -->
                </div><!-- php karta -->
                    
                <!-- sql karta -->
                <div class="col-sm-6 skill-card slide-anim-down">
                    <!-- panel -->
                    <div class="panel panel-default panel-sql">
                        <!-- heading panelu -->
                        <div class="panel-heading">
                            <h3>SQL</h3>
                        </div>
                        <!-- telo panelu -->
                        <div class="panel-body">
                            <!-- obrazok -->
                            <img src="logo/sql.png">
                            <!-- velkost skillu -->
                            <h4>Pokročilý</h4>
                            <!-- progress bar -->
                            <div class="progress">
                                <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"
                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:75%">
                                    75%
                                </div>
                            </div><!-- progress bar -->
                        </div><!-- telo panelu -->
                    </div><!-- panel -->
                </div><!-- sql karta -->

            </div><!-- row -->

            <!-- podnadpis sekcie -->
            <h2 class="section-title">Frameworky a knižnice</h2>
            <!-- vyclearovanie dalsieho contentu -->
            <div class="clear-content"></div>

            <div class="row">

                <!-- jquery karta -->
                <div class="col-sm-4 skill-card slide-anim-down">
                    <!-- panel -->
                    <div class="panel panel-default panel-jquery">
                        <!-- heading panelu -->
                        <div class="panel-heading">
                            <h3>jQuery</h3>
                        </div>
                        <!-- telo panelu -->
                        <div class="panel-body">
                            <!-- obrazok -->
                            <img src="logo/jquery.png">
                            <!-- velkost skillu -->
                            <h4>Mierne pokročilý</h4>
                            <!-- progress bar -->
                            <div class="progress">
                                <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%">
                                    50%
                                </div>
                            </div><!-- progress bar -->
                        </div><!-- telo panelu -->
                    </div><!-- panel -->
                </div><!-- jquery karta -->

                <!-- laravel karta -->
                <div class="col-sm-4 skill-card slide-anim-down">
                    <!-- panel -->
                    <div class="panel panel-default panel-laravel">
                        <!-- heading panelu -->
                        <div class="panel-heading">
                            <h3>LARAVEL</h3>
                        </div>
                        <!-- telo panelu -->
                        <div class="panel-body">
                            <!-- obrazok -->
                            <img src="logo/laravel.png">
                            <!-- velkost skillu -->
                            <h4>Pokročilý</h4>
                            <!-- progress bar -->
                            <div class="progress">
                                <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"
                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:75%">
                                    75%
                                </div>
                            </div><!-- progress bar -->
                        </div><!-- telo panelu -->
                    </div><!-- panel -->
                </div><!-- laravel karta -->

                <!-- bootstrap karta -->
                <div class="col-sm-4 skill-card slide-anim-down">
                    <!-- panel -->
                    <div class="panel panel-default panel-bootstrap">
                        <!-- heading panelu -->
                        <div class="panel-heading">
                            <h3>BOOTSTRAP</h3>
                        </div>
                        <!-- telo panelu -->
                        <div class="panel-body">
                            <!-- obrazok -->
                            <img src="logo/bootstrap.png">
                            <!-- velkost skillu -->
                            <h4>Pokročilý</h4>
                            <!-- progress bar -->
                            <div class="progress">
                                <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"
                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:75%">
                                    75%
                                </div>
                            </div><!-- progress bar -->
                        </div><!-- telo panelu -->
                    </div><!-- panel -->
                </div><!-- bootstrap karta -->

            </div><!-- row -->

            <div class="row other-skills">
                
                <div class="col-sm-6 text-center">
                    <h3 class="subtitle">Ďalšie veci s ktorými sa stretávam:</h3>
                    <ul class="text">
                        <li>Ajax</li>
                        <li>Git</li>
                        <li>Responzívny design<br>Mobile first prístup</li>
                    </ul>
                </div>
                <div class="col-sm-6">
                    <h3 class="subtitle">Mám skusenosti s:</h3>
                    <ul class="text">
                        <li>Web sockety - socket.io</li>
                        <li>Adobe illustrator</li>
                        <li>C</li>
                        <li>Java</li>
                    </ul>
                </div>

            </div><!-- row -->

        </div><!-- container -->
    </section><!-- sekcia - "moje skills" -->

    <!-- sekcia "moje vybavenie" -->
    <section class="content-section">
        <div id="my-gear" class="container-fluid container-cover">

            <!-- content wrapper -->
            <div class="cover-content">
                <!-- nadpis coveru -->
                <h1>Moja výbava</h1>
            </div><!-- content wrapper -->

        </div>
    </section><!-- sekcia "moje vybavenie" -->

    <!-- sekcia - "moje referencie" -->
    <section class="content-section bg-grey">
        <!-- kontajner wrapper - sirsi -->
        <div id="portfolio" class="container">

            <div class="row text-center">
                <!-- nadpis sekcie -->
                <h1 class="section-title">Portfolio</h1>
                <!-- vyclearovanie dalsieho contentu -->
                <div class="clear-content"></div>
                <!-- podnadpis -->
                <h3 class="text">
                    Nižšie nájdete zoznam projektov, ktoré som doteraz vytvoril. Tieto web stránky som programoval
                    vo svojom voľnom čase alebo ako projektové zadania do školy. Každý projekt obsahuje kratký popis,
                    link na stránku projektu a odkaz na zdrojový kód na Githube.
                </h3>
                <br>
                <!-- ukazka projektu -->
                <div class="content-align-vertical slide-anim-left">
                    <!-- foto projektu -->
                    <div class="col-sm-7 project-image">
                        <img class="img-responsive" src="images/blog.png">
                        <!-- overlay vrstva pri hovernuti obrazku -->
                        <div class="middle">
                            <!-- text  -->
                            <h2>MalikBlog</h2>
                            <!-- button - link na projekt -->
                            <a href="http://malikweb.sk/blog" target="_blank" class="btn btn-black">Pozriet projekt</a>
                        </div><!-- overlay vrstva pri hovernuti obrazku -->
                    </div>
                    <!-- text k projektu -->
                    <div class="col-sm-5 project-descr">
                        <!-- nadpis projektu -->
                        <h2 class="project-title">
                            <a href="http://malikweb.sk/blog" target="_blank">MalikBlog</a>
                        </h2>
                        <!-- kratky popis projektu -->
                        <h4 class="project-text">
                            Môj najnovší a zatiaľ najväščí projekt. Aplikácia na písanie článkov formou klasického blogu. Uživatelia môžu vytvárať, editovať, vymazávať svoje články a mnoho iného.
                            <br>Viac info na <a href="http://malikweb.sk/blog" target="_blank">stránke</a> projektu.
                        </h4>
                        <!-- github link na projekt -->
                        <h4><a href="https://github.com/xmalikm/MalikBlog" target="_blank"><strong>Pozrieť projekt na Githube</strong></a></h4>
                        <!-- pouzite technologie -->
                        <h5 class="project-text">
                            <span>Pužité technológie</span>HTML, CSS, JavaScript, PHP, Laravel, Bootstrap, MySQL, Ajax
                        </h5>
                    </div>
                </div><!-- ukazka projektu -->

                <!-- ukazka projektu -->
                <div class="content-align-vertical slide-anim-right">
                    <!-- foto projektu -->
                    <div class="col-sm-7 col-sm-push-5 project-image">
                        <img class="img-responsive" src="images/oh.png">
                        <!-- overlay vrstva pri hovernuti obrazku -->
                        <div class="middle">
                            <!-- text  -->
                            <h2>Olympijskí medajlisti</h2>
                            <!-- button - link na projekt -->
                            <a href="http://malikweb.sk/olympic" class="btn btn-black" target="_blank">Pozriet projekt</a>
                        </div><!-- overlay vrstva pri hovernuti obrazku -->
                    </div>
                    <!-- text k projektu -->
                    <div class="col-sm-5 col-sm-pull-7 project-descr">
                        <!-- nadpis projektu -->
                        <h2 class="project-title">
                            <a href="http://malikweb.sk/olympic" target="_blank">Databáza olympionikov</a>
                        </h2>
                        <!-- kratky popis projektu -->
                        <h4 class="project-text">Jednoduchší projekt zo školy. Slúži ako databáza olympijských
                            medajlistov. Športovcov v tabuľke je možné triediť podľa rôznych kritérii, editovať ich
                            údaje alebo vymazať ich. Tiež je možné pozrieť si detail športovca.</h4>
                         <!-- github link na projekt -->
                        <h4>
                            <a href="https://github.com/xmalikm/Image-Gallery" target="_blank"><strong>Pozrieť projekt na Githube</strong></a>
                        </h4>
                        <!-- pouzite technologie -->
                        <h5 class="project-text">
                            <span>Pužité technológie</span>HTML, CSS, SQL, PHP, Laravel, Bootstrap, JavaScript
                        </h5>
                    </div>
                </div><!-- ukazka projektu -->

                <!-- ukazka projektu -->
                <div class="content-align-vertical slide-anim-left">
                    <!-- foto projektu -->
                    <div class="col-sm-7 project-image">
                        <img class="img-responsive" src="images/image-gallery.png">
                        <!-- overlay vrstva pri hovernuti obrazku -->
                        <div class="middle">
                            <!-- text  -->
                            <h2>Image Gallery</h2>
                            <!-- button - link na projekt -->
                            <a href="http://malikweb.sk/image-gallery" target="_blank" class="btn btn-black">Pozriet projekt</a>
                        </div><!-- overlay vrstva pri hovernuti obrazku -->
                    </div>
                    <!-- text k projektu -->
                    <div class="col-sm-5 project-descr">
                        <!-- nadpis projektu -->
                        <h2 class="project-title">
                            <a href="http://malikweb.sk/image-gallery" target="_blank">Image Gallery</a>
                        </h2>
                        <!-- kratky popis projektu -->
                        <h4 class="project-text">
                            MalikWeb Image Gallery je galéria na prezeranie obrázkov. Galéria je responzívna a využíva mobile first prístup.
                            <br>Viac info na <a href="http://malikweb.sk/image-gallery" target="_blank">stránke</a> projektu.
                        </h4>
                        <!-- github link na projekt -->
                        <h4><a href="https://github.com/xmalikm/Image-Gallery" target="_blank"><strong>Pozrieť projekt na Githube</strong></a></h4>
                        <!-- pouzite technologie -->
                        <h5 class="project-text">
                            <span>Pužité technológie</span>HTML, CSS, JavaScript, Laravel, Bootstrap
                        </h5>
                    </div>
                </div><!-- ukazka projektu -->

                <!-- ukazka projektu -->
                <div class="content-align-vertical slide-anim-right">
                    <!-- foto projektu -->
                    <div class="col-sm-7 col-sm-push-5 project-image">
                        <img class="img-responsive" src="images/my_website.png">
                        <!-- overlay vrstva pri hovernuti obrazku -->
                        <div class="middle">
                            <!-- text  -->
                            <h2>Osobná webstránka</h2>
                            <!-- button - link na projekt -->
                            <a href="http://malikweb.sk" class="btn btn-black" target="_blank">Pozriet projekt</a>
                        </div><!-- overlay vrstva pri hovernuti obrazku -->
                    </div>
                    <!-- text k projektu -->
                    <div class="col-sm-5 col-sm-pull-7 project-descr">
                        <!-- nadpis projektu -->
                        <h2 class="project-title">
                            <a href="http://malikweb.sk" target="_blank">Osobná webstránka</a>
                        </h2>
                        <!-- kratky popis projektu -->
                        <h4 class="project-text">
                            Moja osobná web stránka. Je to prezentačná stránka, kde sa dozviete informácie o mne, o mojich skúsenostiach
                            a môžete si pozrieť niektoré z mojich projektov.</h4>
                         <!-- github link na projekt -->
                        <h4>
                            <a href="https://github.com/xmalikm/malikweb.sk" target="_blank"><strong>Pozrieť projekt na Githube</strong></a>
                        </h4>
                        <!-- pouzite technologie -->
                        <h5 class="project-text">
                            <span>Pužité technológie</span>HTML, CSS, Bootstrap, PHP, JavaScript
                        </h5>
                    </div>
                </div><!-- ukazka projektu -->

            </div><!-- row -->

        </div><!-- kontajner wrapper - sirsi -->
    </section><!-- sekcia - "moje referencie" -->

    <!-- foto album -->
    <section class="content-section">
        <!-- container -->
        <div id="photo-album" class="container-fluid text-center">

            <!-- nadpis sekcie -->
            <h1 class="section-title text-center">Ak práve neprogramujem...</h1>

            <!-- jednotlive fotky -->
            <div class="row">
                <div class="col-xs-6 col-sm-4">
                    <img src="images/photo-album/album_img1.jpg" alt="album1">
                </div>
                <div class="col-xs-6 col-sm-4">
                    <img src="images/photo-album/album_img2.jpg" alt="album2">
                </div>
                <div class="col-xs-6 col-sm-4">
                    <img src="images/photo-album/album_img3.jpg" alt="album3">
                </div>
                 <div class="col-xs-6 col-sm-4">
                    <img src="images/photo-album/album_img4.jpg" alt="album4">
                </div>
                <div class="col-xs-6 col-sm-4">
                    <img src="images/photo-album/album_img5.jpg" alt="album5">
                </div>
                <div class="col-xs-6 col-sm-4">
                    <img src="images/photo-album/album_img6.jpg" alt="album6">
                </div>
            </div>

        </div><!-- container -->
    </section><!-- foto album -->

    <!-- sekcia "kontakt" -->
    <section class="content-section bg-grey container-cover contact-wrapper">
        <!-- container uzsi -->
        <div id="contact" class="container container-wrapper">
            <div class="row">

                <div class="col-sm-12 text-center">
                    <!-- nadpis sekcie -->
                    <h1 class="section-title" >Kontakt</h1>
                    <!-- vyclearovanie dalsieho contentu -->
                    <div class="clear-content"></div>

                    <!-- wrapper pre kontaktne udaje -->
                    <div class="col-sm-6 contact-info-wrapper">
                        <!-- podnadpis -->
                        <h3 class="subtitle">
                            Kontaktné údaje
                        </h3>
                        <!-- info -->
                        <h4 id="contact-info" class="text">
                            <!-- meno -->
                            Martin Malik<br>
                            <!-- email -->
                            <span class="glyphicon glyphicon-envelope"></span> <a href="mailto:xmalikm3@gmail.com">xmalikm3@gmail.com</a><br>
                            <!-- tel. cislo -->
                            <span class="glyphicon glyphicon-earphone"></span><a href="tel:+421915057615">+421 915 057 615</a><br>
                            <!-- adresa -->
                            <p id="address">
                                <span class="glyphicon glyphicon-map-marker"></span> Športová 7
                                <span>Bratislava, 831 04</span>
                                <span>Slovak Republic</span>
                            </p>
                        </h4><!-- info -->
                        <!-- social icons -->
                        <div class="social-icons">
                            <a href="https://www.facebook.com/martin.malik.14" target="_blank">
                                <img src="/../files/icons/facebook-icon.png" title="Malik Facebook" alt="Malik FB">
                            </a>
                            <a href="https://plus.google.com/u/0/104749510764663008968" target="_blank">
                                <img src="/../files/icons/google-icon.png" title="Malik Google+" alt="Malik G+">
                            </a>
                            <a href="https://github.com/xmalikm" target="_blank">
                                <img src="/../files/icons/github-icon.png" title="Malik Github" alt="Malik Git">
                            </a>
                            <a href="" target="_blank">
                                <img src="/../files/icons/linkedin-icon.png">
                            </a>
                        </div><br>
                    </div><!-- wrapper pre kontaktne udaje -->

                    <!-- kontaktny formular -->
                    <div class="col-sm-6 contact-form text-left">
                        <!-- podnadpis -->
                        <h3 class="subtitle">
                            Neváhajte ma kontaktovať
                        </h3>
                        <!-- text -->
                         <h4 class="text">
                            V prípade akejkoľvek otázky ma neváhajte kontaktovať. Veľmi rád vám odpoviem.
                         </h4>
                        <!-- message pri odoslani formularu -->
                        <?php if (!empty($msg)) {
                            echo "<h3>$msg</h3>";
                        } ?>
                        <!-- formular -->
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."#contact"); ?>">
                            <div class="form-group">
                                <!-- <label for="meno">Meno</label> -->
                                <input type="text" class="form-control" name="name" id="name" required="" placeholder="Meno">
                                <span class="error"><?php echo $nameErr;?></span>
                            </div>
                            <div class="form-group">
                                <!-- <label for="email">E-mail</label> -->
                                <input type="email" class="form-control" name="email" id="email" required="" placeholder="E-mail">
                                <span class="error"><?php echo $emailErr;?></span>
                            </div>
                            <div class="form-group">
                                <!-- <label for="sprava">Vaša správa</label> -->
                                <textarea class="form-control" rows="10" name="message" id="message" required="" placeholder="Vaša správa"></textarea>
                                <span class="error"><?php echo $messageErr;?></span>
                            </div>
                            <button type="submit" value="Send" class="btn btn-lg btn-black subtitle">Odoslať správu</button>
                        </form><!-- formular -->
                    </div><!-- kontaktny formular -->
                </div>

            </div><!-- row -->
        </div><!-- container uzsi -->
    </section><!-- sekcia "kontakt" -->

    <!-- container full-with s google mapou -->
    <div class="container-fluid map-container">
        <div class="row">
            <div class="col-sm-12">
                <!-- google mapa -->
                <div id="google-map"></div>
            </div>
        </div><!-- row -->
    </div><!-- container full-with -->

    <!-- footer -->
    <footer>
        <div class="container-fluid text-center">
            <div class="row">
                <div class="col-sm-12 social-icons">
                    <h3>Nájdete ma aj na</h3>
                    <a href="https://www.facebook.com/martin.malik.14" target="_blank"><img src="/../files/icons/facebook-icon.png" title="Malik Facebook" alt="Malik FB"></a>
                    <a href="https://plus.google.com/u/0/104749510764663008968" target="_blank"><img src="/../files/icons/google-icon.png" title="Malik Google+" alt="Malik G+"></a>
                    <a href="https://github.com/xmalikm" target="_blank"><img src="/../files/icons/github-icon.png" title="Malik Github" alt="Malik Git"></a>
                    <a href="" target="_blank"><img src="/../files/icons/linkedin-icon.png"></a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 contact">
                    <h4>Pre viac informácii volajte na <a href="tel:+421915057615">+421 915 057 615</a>
                    alebo píšte na <a href="mailto:xmalikm3@gmail.com">xmalikm3@gmail.com</a></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    Copyright © 2017 Martin Malik. All rights reserved.
                </div>
            </div>
        </div>
    </footer>
    <!-- footer -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="script.js"></script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDvqylp7QZeIfpfEFSGzCXtY124nisVVmk&callback=initMap">
</script>
</body>
</html>
