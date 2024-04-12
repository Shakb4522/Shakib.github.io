<?php

session_start();
if($_SESSION['admin']!=="correct"){
    header("Location:index.php");
}



?>

<?php

$conn = new mysqli('localhost', 'root', 'chakib', 'project');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM cavaliers";
$result = mysqli_query($conn, $sql);

$counter = "";
if(isset($_POST['submit']) && isset($_FILES['image'])){
    
    $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
    $nom=$_POST['nom'];
    $prenom=$_POST['prenom'];
    $date=$_POST['date'];
    $lieu=$_POST['lieu'];
    $coach=$_POST['coach'];
    $ntel=$_POST['ntel'];
    $groupage=$_POST['groupage'];
    $adresse=$_POST['adresse'];
    $email=$_POST['email'];
    
    $categorie=$_POST['cat'];
    $date_pa = "0000-00-00";
    $date_assurance = "0000-00-00";
    $nbr = "";
    $date_aujourdhui = DATE('Y-m-d');
    $query = "SELECT IFNULL(MAX(id), 0) + 1 AS next_id FROM cavaliers";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $next_id = $row["next_id"];
    
    $sql = "INSERT INTO `cavaliers`(`id`, `nom`, `prenom`, `date_de_naissance`, `date_ins`, `coach`, `ntel`, `categorie`, `date_pa`, `nbr`, `lieu`, `image`, `date_assurance`, `email`, `adresse`, `groupage`) VALUES ('$next_id','$nom','$prenom','$date','$date_aujourdhui','$coach','$ntel','$categorie','$date_pa','$nbr','$lieu','$image','$date_assurance','$email','$adresse','$groupage')";
    $result = mysqli_query($conn , $sql);
    

if (!$result) {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}else {
    header("Location:cavalier.php");
}

}
?> 





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club equestre</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="fontawesome-free-6.4.2-web/css/all.css">
    <link rel="stylesheet" href="fontawesome-free-6.4.2-web/css/fontawesome.min.css">
    <link rel="stylesheet" href="fontawesome-free-6.4.2-web/css/fontawesome.css">
    
    <link rel="stylesheet" href="css/cavalier.css">

</head>
<body>
<div class="ajouter">
        <i class="fa-solid cancelAjouter fa-x"></i>
        <h4>Créer un cavalier</h4>
        <label for="imageInput">
            <img id="imagePreview" src="" alt="">
        </label>
        


        <form action="" method="post" enctype="multipart/form-data">
        <input id="imageInput" name="image" required type="file">
            <div class="feat">
                <input name="nom" type="text" required>
                <span>Nom</span>
            </div>
            <div class="feat">
                <input name="prenom" type="text" required>
                <span>Prénom</span>
            </div>
            <div class="feat">
                <input name="date" type="date" required>
                <span style="z-index: 50000000000000; background-color: white; padding: 9px 10px 5px 10px  ; top: 4px;">Date de naissance</span>
            </div>
            <div class="feat">
                <input name="lieu" type="text" required>
                <span>Lieu de nassance</span>
            </div>
            <div class="feat">
                <input pattern="^(05|06|07)\d{8}$" name="ntel" type="text" required>
                <span>Numero de téléphone</span>
            </div>
            <div class="feat">
                <select name="coach"  id="mySelect2" id="">
                    <?php  
                    $sql = "SELECT * FROM coachs";
                    $result = mysqli_query($conn , $sql);
                    while ($row = $result -> fetch_assoc()){
                     echo '  <option value=" '. $row['nom'] .' '. $row['prenom'] . '">' . $row['nom'] . '  '. $row['prenom']  .' </option> ';

                    }
                    ?>
                </select>
                <span style="z-index: 50000000000000; background-color: white; padding: 9px 5px 5px 15px  ; top: 4px;"  class="span3">Nom du coach</span>
            </div>
            <div class="feat">
                <input name="groupage" type="text" required>
                <span>Groupage</span>
            </div>
            <div class="feat">
                <select id="mySelect" name="cat" id="">
                    <option value="1er Niveau">1er Niveau</option>
                    <option value="2eme Niveau">2eme Niveau</option>
                    <option value="3eme Niveau">3eme Niveau</option>
                    <option value="4eme Niveau">4eme Niveau</option>
                    <option value="Poney">Poney</option>
                </select>
                <span style="z-index: 50000000000000; background-color: white; padding: 9px 13px 5px 15px  ; top: 4px;" class="span">Catégorie</span>
            </div>
            <div class="feat">
                <input name="adresse" type="text" required>
                <span>L'adresse </span>
            </div>
            <div class="feat">
                <input name="email" type="email" required>
                <span>Email</span>
            </div>
            
            <div class="btn2">
                <button type="submit" name="submit">Confirmer</button>
            </div>
        </form>

    </div>
    
    
 <?php
$sql3 = "SELECT * FROM cavaliers";
$result3 = mysqli_query($conn, $sql3);

while($row3=$result3->fetch_assoc()){
    echo '
    <div data-value="'.$row3['id'].'" class="sup">
    <i class="fa-solid hhhh fa-x"></i>
<h3>Confirmer</h3>
<h5>Vous etes sur de suprimer le cavalier</h5>
<h6>'.$row3['nom'].' '.$row3['prenom'].' ?</h6>
<h4 class="oui" data-meriem="'.$row3['id'].'">Oui</h4>
</div>
    
    
    
     '; 



}


 ?>
     <?php     
     
     $sql4 = "SELECT * FROM cavaliers";
$result4 = mysqli_query($conn, $sql4);

while($row4=$result4->fetch_assoc()){
    


    



echo '
    



    



    <div data-id="'.$row4['id'].'" class="profile">
        
        <div class="c">
            <i class="fa-solid fa-x"></i>
        </div>
        <div class="btn">
            <a class="kl" data-value="'.$row4['id'].'" >Supprimer</a>
            <a href="modifier_cavalier.php?id='.$row4['id'].'">Modifier</a>
        </div>
        <img class="ds" src="data:image/png;base64,' . base64_encode($row4['image']) . '">
        <div class="inside">
            <div class="en2">
                <h3>ID:</h3>
                <h3 class="second">'.$row4['id'].'</h3>
            </div>
            <div class="en2">
                <h3>Date dinscription:</h3>
                <h3 class="second">'.$row4['date_ins'].'</h3>
            </div>
            <div class="en2">
                <h3>Catégorie:</h3>
                <h3 class="second">2ème niveau</h3>
            </div>
            <div class="en2">
                <h3>Nom complet:</h3>
                <h3 class="second">'.$row4['nom'].'  '.$row4['prenom'].'</h3>
            </div>
            
            <div class="en2">
                <h3>Date de naissance:</h3>
                <h3 class="second">'.$row4['date_de_naissance'].'</h3>
            </div>
            <div class="en2">
                <h3>Lieu de naissance:</h3>
                <h3 class="second">'.$row4['lieu'].'</h3>
            </div>
            <div class="en2">
                <h3>Groupage:</h3>
                <h3 class="second">'.$row4['groupage'].'</h3>
            </div>

            <div class="en2">
                <h3>Coach:</h3>
                <h3 class="second">'.$row4['coach'].'</h3>
            </div>
            <div class="en2">
                <h3>N° Telephone:</h3>
                <h3 class="second">'.$row4['ntel'].'</h3>
            </div>
            <div class="en2">
                <h3>Adresse email:</h3>
                <h3 class="second">'.$row4['email'].'</h3>
            </div>
            <div class="en2">
                <h3>Adresse:</h3>
                <h3 class="second">'.$row4['adresse'].'</h3>
            </div>
            
            <div class="en2">
                <h3>Nombre de seances restants:</h3>
                <h3 class="second">'.$row4['nbr'].'</h3>
            </div>
            <div class="en2">
                <h3>Date paiement dabonnement:</h3>
                <h3 class="second">'.$row4['date_pa'].'</h3>
            </div>
            <div class="en2">
                <h3>Date paiement dassurance:</h3>
                <h3 class="second">'.$row4['date_assurance'].'</h3>
            </div>
        </div>
       
    </div>
 ';}
?>  






    <div class="header">
        <h3>Cavaliers</h3>
        <img src="images/qq.png" alt="">
        
        <h4 id="home"><p>Home</p> <i class="fa-solid fa-house"></i></h4>
    </div>
    <div class="sousHeader">
        <h5>Veuillez ajouter un cavalier ou sélectionner le cavalier que vous souhaitez visiter pour afficher son profil, puis choisissez de le modifier ou de le supprimer.</h5>
    </div>
    <div class="bar">
        <input class="search"  type="text" placeholder="Entrer le nom du cheval">
        <input class="search2"  type="text" placeholder="Entrer le ID du cavalier">
        <i class="fa-solid fa-right-left"></i>
        <i class="fa-solid fa-user-plus"></i>


    </div>
   <div class="table">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Date de naissance</th>
                <th>Groupage</th>
                <th>Coach</th>
                <th>N° Téléphone</th>
                <th>Catégorie</th>
                
            </tr>
        </thead>
        <tbody>
             <?php
            $sqll = "SELECT * FROM cavaliers";
            $resultt = mysqli_query($conn, $sqll);
            while($row=$resultt->fetch_assoc()){
                echo ' 
                <tr class="tr" data-value="'.$row['id'].'">
                <td>'.$row['id'].'</td>
                <td>'.$row['nom'].'</td>
                <td>'.$row['prenom'].'</td>
                <td>'.$row['date_de_naissance'].'</td>
                <td>'.$row['groupage'].'</td>
                <td>'.$row['coach'].'</td>
                <td>'.$row['ntel'].'</td>
                <td>'.$row['categorie'].'</td>
                
            </tr>
                 ';
            }
            
            
            
            ?>
           
        </tbody>
    </table>
   </div>
    
    <script src="js/cavalier.js"></script>
    <script>
        // Get references to the input and image elements
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        
        // Add an event listener to the input element to listen for changes
        imageInput.addEventListener('change', function() {
            // Check if a file has been selected
            if (imageInput.files && imageInput.files[0]) {
                // Create a FileReader object to read the selected file
                const reader = new FileReader();
                
                // Define a callback function to run when the file is loaded
                reader.onload = function(e) {
                    // Set the source of the image element to the loaded file data
                    imagePreview.src = e.target.result;
                };
                
                // Read the selected file as a data URL
                reader.readAsDataURL(imageInput.files[0]);
            }
        });
    </script>
    <script>
        // Get references to the input and image elements
        const imageInput = document.getElementById('imageInputt');
        const imagePreview = document.getElementById('imagePrevieww');
        
        // Add an event listener to the input element to listen for changes
        imageInput.addEventListener('change', function() {
            // Check if a file has been selected
            if (imageInput.files && imageInput.files[0]) {
                // Create a FileReader object to read the selected file
                const reader = new FileReader();
                
                // Define a callback function to run when the file is loaded
                reader.onload = function(e) {
                    // Set the source of the image element to the loaded file data
                    imagePreview.src = e.target.result;
                };
                
                // Read the selected file as a data URL
                reader.readAsDataURL(imageInput.files[0]);
            }
        });
    </script>
</body>
</html>