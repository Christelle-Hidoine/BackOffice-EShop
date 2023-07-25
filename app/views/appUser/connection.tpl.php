<div class="container my-4">

    <form action="" method="POST" class="mt-5">
        <div class="form-row">
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

            <!-- token hidden anti-csrf -->
            <input type="hidden" name="token" value="<?= $token ?>">
            
            <div class="col-md-4 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="adresse email" value="<?= $user->getEmail() ?>" aria-describedby="emailHelp">
            </div>
            <div class="col-md-4 mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="mot de passe">
            </div>

            <button type="submit" name="Se Connecter" class="btn btn-primary mt-3">Se connecter</button>

        </div>
    </form>

    <div class="mt-3">   
        <a href="<?= $router->generate('main-home') ?>" class="btn btn-success">
            Retour
        </a>
    </div> 
</div>