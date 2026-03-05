<?php
include("../db.php");

$sql = "SELECT * FROM comptes";
$result = mysqli_query($con, $sql);

$users = array();

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
}
?>

<div class="card-list-users">
<div class="card-users">
    <div class="card-body">

        <h2>Liste des utilisateurs</h2>
        <p>Total des utilisateurs: <?php echo count($users); ?></p>
        <table class="table">
        <thead>
            <tr>
            <th>ID</th>
            <th>Nom d'utilisateur</th>
            <th>Email</th>
            <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['user_id']; ?></td>
                <td><?php echo $user['pseudo']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td>
                <form method="POST" action="supprimer_utilisateur.php">
                    <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
    </div>
</div>
</div>