<?php require_once('vendor/autoload.php');
require_once('Cbrs.php');

$dsn = 'mysql:host=127.0.0.1;dbname=jurnal';
$user = 'root';
$password = '';
$database = new Nette\Database\Connection($dsn, $user, $password);

$id = $_GET['id'];
$hotel = get_hotel_detail($id, $database);

$result = $database->query('SELECT id, Abstract, Title FROM jurnal');
$data = [];
foreach($result as $row){
    $data[$row->id] = pre_process($row->Abstract.' '.$row->Title);
}

$cbrs = new Cbrs();
$cbrs->create_index($data);
$cbrs->idf();
$w = $cbrs->weight();  
$r = $cbrs->similarity($id);
$n = 8;

function pre_process($str){
    $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
    $stemmer = $stemmerFactory->createStemmer();

    $stopWordRemoverFactory = new \Sastrawi\StopWordRemover\StopWordRemoverFactory();
    $stopword = $stopWordRemoverFactory->createStopWordRemover();

    $str = strtolower($str);
    $str = $stemmer->stem($str);
    $str = $stopword->remove($str);

    return $str;
}

function get_hotel_detail($id, $db){
    $rs = $db->fetch('SELECT * FROM jurnal Where id = '.$id);
    return $rs;
}

?>
<!doctype html>
<html lang="en">
    <head>
        <title>Content-based Filtering</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    </head>

    <body>
        <div class="container theme-showcase">
            <div class="jumbotron">
                <h1>Daftar Jurnal dengan Tema Renewable Energy</h1>
                <p>Contoh implementasi Sistem rekomendasi berbasis kontent menggunakan metode TF-IDF dan Cosine Similarity</p>
            </div>
            
            <div class="row">
                <div class="col-md-10">
                    <h2><span class="label label-primary"><?php echo $hotel->Title?></span></h2>
                    <p><strong>Abstract:</strong> <?php echo $hotel->Abstract?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3>Rekomendasi Jurnal yang sesuai</h3>
                    <ol>
                        <?php $i=0;?>
                        <?php foreach($r as $k => $row):?>
                            <?php if($i==$n) break;?>
                            <?php if($row==1) continue;?>
                            <?php $h = get_hotel_detail($k, $database);?>
                            <li><a href="detail.php?id=<?php echo $h->id ?>">
                                <?php echo $h->Title ?></a> (<?php echo $row?>)
                            </li>
                            <?php $i++ ?>
                        <?php endforeach ?>    
                    </ol>
                </div>
            </div>
        </div>
    </body>
</html>
