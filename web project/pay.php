<?php require_once('complementary/header.php');
if(!isset($_SESSION['pay'])) {
    header('location:homepage.php');
}
$id = $_GET['id'] ; 
$selectedData = $conn->query("SELECT * FROM courses where id = '$id' ") ; 
$selectedData->execute()  ;
$data = $selectedData->fetch(PDO::FETCH_ASSOC) ; 
unset($_SESSION['pay']) ;
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5c5946fe44.js" crossorigin="anonymous"></script>
    <title>Pay Page</title>
</head>

<body>

    <!-- <nav class="navbar navbar-expand-lg navbar-light bg-dark" > -->
    <!-- <div class="container" style="margin-top: 20%">
        <a class="navbar-brand  text-white" href="#">Pay Page</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

        </div> -->
    </div>
    <div class="home">
        <div class="overlay">
            <div class="home-content">
                <h1 class="main-address">Pay With Paypal Page</h1>
                <p class="home-description">
                    <!-- content in the front page -->
                    - Order Details 
                </p>
                <p style="color: white;"> <?php echo $data['name_of_course'] ;?> , &dollar;<?php echo $data['price'] ; ?></p>
                <div class="container" style="margin-left: 10%; float: left">
                    <!-- Replace "test" with your own sandbox Business account app client ID -->
                    <script src="https://www.paypal.com/sdk/js?client-id=AeqXt3Yf0deDvX-7ffT0hwxrqSL77lvM6hcD9qcEA7mVdKgGQ7ZXqg_X1maSFdP9w7i9IP6AEXYbQB7O&currency=USD"></script>
                    <!-- Set up a container element for the button -->
                    <div id="paypal-button-container" style="z-index: 100;"></div>
                    <script>
                        paypal.Buttons({
                            // Sets up the transaction when a payment button is clicked
                            createOrder: (data, actions) => {
                                return actions.order.create({
                                    purchase_units: [{
                                        amount: {
                                            value: "<?php echo $data['price'] ; ?>" // Can also reference a variable or function
                                        }
                                    }]
                                });
                            },
                            // Finalize the transaction after payer approval
                            onApprove: (data, actions) => {
                                return actions.order.capture().then(function(orderData) {
                                    <?php $_SESSION['paid'] = $id ; $_SESSION['price'] = $data['price'] ; ?>
                                    window.location.href = 'success.php';
                                });
                            }
                        }).render('#paypal-button-container');
                    </script>

                </div>
            </div> <!-- close home content div -->
        </div> <!-- close overlay div -->
    </div> <!-- close home div -->
    <!-- testing using sandbox fake money not live mode ....   -->
    <?php require_once('complementary/footer.php'); ?>

    <body>

</html>