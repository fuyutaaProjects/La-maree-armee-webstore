<style>
.boite-input{
    border-radius:30px;
}
</style>

<div>

    <form id="signup_form" action="register.php" method="post">
        <div>
            <h2>Register Here</h2>
        </div>
        <div>
            <input class="input formulaire boite-input" type="text" name="pseudo" id="pseudo" placeholder="Pseudo">
        </div>
        <div>
            <input class="input formulaire boite-input" type="text" name="prenom" id="prenom" placeholder="Prénom">
        </div>
        <div>
            <input class="input formulaire boite-input" type="text" name="nom" id="nom" placeholder="Nom">
        </div>
        <div>
            <input class="input formulaire boite-input" type="email" name="email" placeholder="Adresse mail">
        </div>
        <div>
            <input class="input formulaire boite-input" type="password" name="password" id="password" placeholder="Mot de passe">
        </div>
        <div>
            <input class="input formulaire boite-input" type="password" name="repassword" id="repassword" placeholder="Confirmez le mot de passe">
        </div>
        <div>
            <input class="input formulaire boite-input" type="text" name="mobile" id="mobile" placeholder="Numéro de téléphone mobile">
        </div>
        <div>
            <input class="input formulaire boite-input" type="text" name="address1" id="address1" placeholder="Numéro et rue">
        </div>
        <div>
            <input class="input formulaire boite-input" type="text" name="address2" id="address2" placeholder="Ville">
        </div>
        <div>
            <input class="input formulaire boite-input" type="text" name="departement" id="departement" placeholder="Code départemental">
        </div>
        <div class="register_type_de_compte">
            <p>Voulez-vous vendre des produit ? :</p>
            <input class="input formulaire boite-input" type="checkbox" name="type_de_compte" id="type_de_compte" value="1">
        </div>
        <div>
            <input id="signup_button" class="bouton-principal" value="Sign Up" type="submit" name="signup_button">
        </div>
    </form>
</div>
