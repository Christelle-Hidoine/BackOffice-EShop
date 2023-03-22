
<div class="container my-4">
    <form action="" method="POST" class="col-3 m-auto">
        <?php       
            if (isset($error)) : ?>
            <div class="alert alert-warning" role="alert">
                <?= $error ?>
            </div>
        <?php endif; ?> 
        <?php       
            if (isset($errorList)) : 
                foreach ($errorList as $error) :?>
                <div class="alert alert-warning" role="alert">
                    <?= $error ?>
                </div>
        <?php endforeach; endif; ?> 
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="adresse email" value="<?= $user->getEmail() ?>" aria-describedby="emailHelp">
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