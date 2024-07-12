<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe Payment</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <button id="checkout">Payer 20 EUR</button>

    <script src="../../assets/js/control/checkout.js"></script>
    <script>
        
        var stripe = Stripe("pk_test_51P0Nwr06cz5xLY6TQrioPb29OEZURuvoNUA1th0FYMIjJhPJvIoOjqOVnEsN2QTeCJRowOoc5UASb1KJ9L7RRKLc00jlWe9YJU");
        console.log(stripe);
        // var stripe = Stripe("pk_live_51P0Nwr06cz5xLY6T9QTYcf7LnL8DQf3lSBJgROLoFDCmXr1hZj5xQhOGSpMKguNYPXcRrEYdZH2Q0qsLwNPbqToX00nxuYkhkl"); 
        
        document.getElementById("checkout").addEventListener("click", function () {

            stripe.redirectToCheckout({
                lineItems: [
                    {
                        // price: "price_1P0PU306cz5xLY6TzJi7YSHz", // Remplacez par l'ID de votre prix
                        price : "price_1P0OTN06cz5xLY6TdtEP9pmc",
                        quantity: 1,
                    }
                ],
                mode: "payment",
                successUrl: "http://localhost/neurotest/model/home/set-code-acces.php",
                cancelUrl: "http://localhost/views/home/welcome.php",
            }).then(function (result) {
                // console.log(result);
                if (result.error) {
                    console.error(result.error.message);
                }
            });
        });
       
     

        
    </script>
</body>
</html>