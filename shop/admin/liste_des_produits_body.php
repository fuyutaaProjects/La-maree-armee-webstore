<?php
include("../db.php");

?>
<div class="card-liste_des_produits">
    <div class="card-header">
        <h2 class="card-title">Liste des produits</h2>

    </div>
    <div class="card-body">
        <br>
            <table class="table" id="prod">
                <thead class="">
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Niveau requis</th>
                        <th>Portée</th>
                        <th>Vitesse d'encrage</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $result = mysqli_query($con, "SELECT * FROM produits ORDER BY nom ASC");

                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $nom = $row['nom'];
                        $prix = $row['prix'];
                        $image = $row['image'];
                        $niveau = $row['niveau'];
                        $portee = $row['portee'];
                        $vitesse_encrage = $row['vitesse_encrage'];
                        $legeretee = $row['legeretee'];
                        echo "<tr>
                                <td><img src='../img_produit/$image'></td>
                                <td>$nom</td>
                                <td>$niveau</td>
                                <td>$portee</td>
                                <td>$vitesse_encrage</td>
                                <td>$legeretee</td>
                                <td>$prix</td>
                                <td class='text-center'>
                                    <a class='btn-danger' href='delete_produit.php?id=$id'>Delete</a>
                                </td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
</div>


<script>
// Javascript Généré par ChatGPT
  document.querySelectorAll('.btn-danger').forEach(button => {
  button.addEventListener('click', function() {
      const produitId = this.dataset.id;
      
      fetch(`delete_produit.php?id=${produitId}`, {
          method: 'DELETE',
      })
      .then(response => {
          if (response.ok) {
              window.location.reload(true);
          } else {
              console.error('Error deleting produit');
          }
      })
      .catch(error => {
          console.error('Error:', error);
      });
    });
  });
</script>
