<?php
    /*
        Auteur: AWADEME FINANFA RONALDO
        Email: awademeronaldoo@gmail.com
    */
     require_once "db.php";
    //On détermine sur qu'elle page on se trouve
    if(isset($_GET['page']) && !empty($_GET['page'])){
        $PageCourante = (int) $_GET['page'];
    }else{
        $PageCourante = 1;
    }
    //On détermine ensuite le nombre d'utilisateurs
    $nbrUsers = $bdd->prepare("SELECT COUNT(*) as n FROM users ORDER BY pseudo ASC");
    $nbrUsers->execute();
    $TotalUsers = $nbrUsers->fetch();
    $Total = (int)($TotalUsers['n']);
    //On détermine le nombre d'utilisateurs par page
    $ParPage = 10;
    //On calcul le nombre de page total
    $nbTotal = ceil($Total/$ParPage);

    if($PageCourante > $nbTotal ){
        $PageCourante = $nbTotal;
    }else if($PageCourante < 0){
        $PageCourante = 1;
    }
    //Calcul du premier nombre d'utilidateurs à afficher sur la page
    $premier =  ($PageCourante * $ParPage)-$ParPage;

    

    $req = $bdd->prepare("SELECT * FROM users ORDER BY pseudo ASC LIMIT $premier,$ParPage");
    $req->execute();
    $users = $req->fetchAll();
 

?>


<!DOCTYPE html>
<html>
    <head>
        <title>Pagination en PHP</title>
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <div class="col-md-9">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pseudo</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($users as $user){
                        ?>
                        <tr>
                        <td><?=$user['id']?></td>
                            <td><?=$user['pseudo']?></td>
                            <td><?=$user['email']?></td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Pseudo</th>
                            <th>Email</th>
                        </tr>
                    </tfoot>
                </table>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link <?php if($PageCourante == 1){echo 'diseabled';}else echo 'active';?>" href="index.php?page=<?=$PageCourante-1?>">Précédent</a>
                        </li>
                        <?php
                            for($i=1;$i<=$nbTotal;$i++){
                            ?>
                            <?php
                            if($PageCourante == $i){
                            ?>
                            <li class="page-item active">
                            <?php
                            }else{

                                ?>
                                <li class="page-item">
                                <?php
                            }
                            ?>
                            
                                <a class="page-link" href="index.php?page=<?=$i?>">
                                    <?=$i?>
                                </a>
                            </li>
                            <?php
                            }
                           
                        ?>
                        <li class="page-item">
                            <a class="page-link <?php if($PageCourante == $nbTotal){echo 'diseabled';}else echo 'active';?>" href="index.php?page=<?=$PageCourante+1?>">Suivant</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </body>
</html>