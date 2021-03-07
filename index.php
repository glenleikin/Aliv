<?php
    include "connection.php";
    if (isset($_POST['add'])) {
        if (isset($_POST['hotstone']) && is_numeric($_POST['hotstone'])) {
            setcookie(
                "hotstone",
                $_POST['hotstone'],
                time() + (60 * 60 * 24 * 90)
            );
        }
        if (isset($_POST['reflexology']) && is_numeric($_POST['reflexology'])) {
            setcookie(
                "reflexology",
                $_POST['reflexology'],
                time() + (60 * 60 * 24 * 90)
            );
            
        }
        if (isset($_POST['thai']) && is_numeric($_POST['thai'])) {
            setcookie(
                "thai",
                $_POST['thai'],
                time() + (60 * 60 * 24 * 90)
            );
            
        }
    header("location:#cart");
}
if (isset($_GET['hotstone']) && $_GET['hotstone']=='delete') {
    setcookie(
        "hotstone",
        "0"
    );
    header("location:./index.php");
}
if (isset($_GET['reflexology']) && $_GET['reflexology']=='delete') {
    setcookie(
        "reflexology",
        "0"
    );
    header("location:./index.php");
}
if (isset($_GET['thai']) && $_GET['thai']=='delete') {
    setcookie(
        "thai",
        "0"
    );
    header("location:./index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" 
    crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
    <title>Massage site</title>
</head>
<body>
<style>
    /* i put it here cause in the in style.css wasnt working */
    .bg{
    background-image: url('./images/bg.jpg');
      height: 100vh;
}
</style>
<div class="bg">
    <nav class="navbar navbar-expand-lg navbar-light" id="navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="#" style="font-weight: bold">Aliv</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
            <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#services">Services</a>
            </li>
            <li class="nav-item">
            <a class="nav-link text-dark" href="#">Contact us</a>
            </li>            
        </ul>
    </div>
    </div>
    </nav>
    <section class="py-6">
        <div class="container">
            <div class="text-center w-75 mx-auto mb-5">
            <h1 class="display-4 mb-3">The time to <span style="font-weight: bold">relax</span> is when you don't have time for it.</h1>
            <p class ="lead text-muted mb-5">More than 15 years working</p>
            <a href="#services" class="btn btn-lilac mr-2 mb-4">Our services</a>
            <a href="#" class="btn btn-lilac mb-4">Contact us</a>
            <ul class="list-unstyled list-inline">
                <li class="list-inline-item mr-4"><small>Hot Stone Massage</small></li>
                <li class="list-inline-item mr-4"><small>Reflexology</small></li>
                <li class="list-inline-item mr-4"><small>Thai Massage</small></li>
            </ul>
            </div>
        </div>
    </section>
    </div>
    <section class="py-g bg-lilac">
        <div class="container">
            <h2 id="services" class="pt-5"style="font-weight: bold">Our services</h2>
            <p class ="lead text-muted mb-5">Find the perfect massage for you</p>
            <div class="row">
                <?php
                    $query = "SELECT * FROM services ORDER BY id ASC";
                    $statement = $connect->prepare($query);
                    $statement->execute();
                    $result = $statement->fetchAll();
                    foreach($result as $row)
                    {
                    ?>
                <div class="col-lg-4">
                    <div class="card border-0 rounded-0 my-3">
                        <div class="card-header bg-light border-0 p-4">
                                <h4 class="mb-3" style="font-weight: bold"><?php echo $row["name"]; ?></h4>
                                <h5 class=""style="font-weight: bold">$<?php echo $row["price"]; ?></h5>
                                <div class="text-center">
                                <img src="images/<?php echo $row["image"]; ?>" class="rounded img-fluid" alt="...">
                                </div>
                        </div>
                        <div class="card-body border-0 p-4">
                            <p>
                            <?php echo $row["description"]; ?>
                            </p>
                        </div>
                        <form action="#services" method="post">
                        <div class="card-footer bg-light border-0 text-center p-4">
                        <input type="text" class="btn mb-3" name="<?php echo $row["varname"]; ?>" value="1" />
                        </div>
                        <div class="card-footer bg-light border-0 text-center p-4">
                            <input type="submit" class="btn btn-lilac mb-3" name="add" value="Add to Cart" />
                        </div>
                        </form>			               
                    </div>
                </div>
                <?php
                }
                ?>
        </section>
        <section class="py-6 bg-light">
            <div class="container" id="cart">
                <h2>Your shopping cart:</h2>
        <?php
        if (!isset($_COOKIE['hotstone']) && !isset($_COOKIE['reflexology']) 
        && !isset($_COOKIE['thai'])) {
            echo "<p style=color:red>Your shopping cart is empty.</p>";
        } else {
            $hotstone = (isset($_COOKIE['hotstone'])) ? $_COOKIE['hotstone'] : 0;
            $reflexology = (isset($_COOKIE['reflexology'])) ? $_COOKIE['reflexology'] : 0;
            $thai = (isset($_COOKIE['thai'])) ? $_COOKIE['thai'] : 0;
        ?>
            <table class="table">
                <tr>
                    <th>Services</th>
                    <th>Sessions</th>
                    <th></th>
                </tr>
                <tr>
                    <td>Hot Stone</td>
                    <td><?= $hotstone ?></td>
                    <td><a class ="text-dark"href="./index.php?hotstone=delete"><ion-icon name="trash-outline"></ion-icon></a></td>
                </tr>
                <tr>
                    <td>Reflexology</td>
                    <td><?= $reflexology ?></td>
                    <td><a class ="text-dark" href="./index.php?reflexology=delete"><ion-icon name="trash-outline"></ion-icon></a></td>
                </tr>
                <tr>
                    <td>Thai Massage</td>
                    <td><?= $thai ?></td>
                    <td><a class ="text-dark" href="./index.php?thai=delete"><ion-icon name="trash-outline"></ion-icon></a></td>
                </tr>
            </table>
                <?php
                }
                ?>
            </div>
        </div>
    </section>

    <section>
        <div class="container">           
        <div class="pt-4">
            <h5 class="mb-3">Total</h5>
            <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                <div>
                    <strong>The total amount of</strong>
                </div>
                <?php
                    $total = total($hotstone, $reflexology, $thai);
                    function total($h, $r, $t){
                        $total = ($h * 100.00)+($r*150.00)+($t *125.00);
                        return $total;                   
                    }
                ?>
                <span><strong>$<?php echo $total; ?></strong></span>
            </li>
            </ul>
            <button type="button" class="btn btn-lilac btn-block">Go to checkout</button>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="mb-4">We accept</h5>
                    <img class="mr-2" width="45px"
                        src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/visa.svg"
                        alt="Visa">
                    <img class="mr-2" width="45px"
                        src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/amex.svg"
                        alt="American Express">
                    <img class="mr-2" width="45px"
                        src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/mastercard.svg"
                        alt="Mastercard">
            </div>
        </div>
        </div>
    </section>

    <section>
        <div class="row no-gutters">
            <div class="col-lg-4 col-md-12 py-4 text-center border-right border-bottom">
                <small><a href="" class="text-dark"><ion-icon name="logo-instagram"></ion-icon>Instagram</a></small>
            </div>
            <div class="col-lg-4 col-md-12 py-4 text-center border-right border-bottom">
                <small><a href="" class="text-dark"><ion-icon name="logo-facebook"></ion-icon>Facebook</a></small>
            </div>
            <div class="col-lg-4 col-md-12 py-4 text-center border-right border-bottom">
                <small><a href="" class="text-dark"><ion-icon name="logo-whatsapp"></ion-icon>Whatsapp</a></small>
            </div>
        </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" 
    integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" 
    crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" 
    integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" 
    crossorigin="anonymous">
    </script>   
</body>
</html>