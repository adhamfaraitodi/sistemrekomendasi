<?php require_once('vendor/autoload.php');
require_once('Cbrs.php');

$dsn = 'mysql:host=127.0.0.1;dbname=jurnal';
$user = 'root';
$password = '';
$database = new Nette\Database\Connection($dsn, $user, $password);

$result = $database->query('SELECT id, Authors, Title, Year, Publisher, ArticleURL, Abstract,GSRank FROM jurnal order by rand() limit 0,10');

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
            <div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Authors</th>
                            <th>Year</th>
                            <th>Publisher</th>
                            <th>Abstract</th>
                            <th>GSRank</th>
                            <th>Link Jurnal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1?>
                        <?php foreach($result as $row):?>
                        <tr>
                            <td><?php echo $no++?></td>
                            <td><a href="detail.php?id=<?php echo $row->id ?>">
                                <?php echo $row->Title ?></a>
                            </td>
                            <td><?php echo $row->Authors ?></td>
                            <td><?php echo $row->Year ?></td>
                            <td><?php echo $row->Publisher ?></td>
                            <td><?php echo $row->Abstract ?></td>
                            <td><?php echo $row->GSRank ?></td>
                            <td><?php echo $row->ArticleURL ?></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
