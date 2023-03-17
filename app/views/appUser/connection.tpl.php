<div class="container my-4">
    <form action="" method="POST" class="col-3 m-auto">
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="adresse email" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="mot de passe">
    </div>
    <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
    <div class="col-3 m-auto mt-3">   
        <a href="<?= $router->generate('main-home') ?>" class="btn btn-primary">
            Retour
        </a>
    </div> 
</div>