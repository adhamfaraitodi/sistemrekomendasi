<?php require_once('vendor/autoload.php');
require_once('Cbrs.php');

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
$kalimat = $_POST['kalimat'];
$kd = Pre_process($kalimat);
echo $kd;
echo "<br><a href='kata_dasar.php'>Kembali</a>";
?>