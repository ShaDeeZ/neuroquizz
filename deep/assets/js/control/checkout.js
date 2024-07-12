// var stripe = Stripe("pk_test_51P0Nwr06cz5xLY6TQrioPb29OEZURuvoNUA1th0FYMIjJhPJvIoOjqOVnEsN2QTeCJRowOoc5UASb1KJ9L7RRKLc00jlWe9YJU");
        
//const stripe = Stripe('pk_test_51P0Nwr06cz5xLY6TQrioPb29OEZURuvoNUA1th0FYMIjJhPJvIoOjqOVnEsN2QTeCJRowOoc5UASb1KJ9L7RRKLc00jlWe9YJU');

/*
document.getElementById("checkout").addEventListener("click", async function () {
    try {
        const session = await stripe.checkout.sessions.create({
            // success_url: 'https://example.com/success',
            line_items: [
                {
                    price: 'price_1P0OTN06cz5xLY6TdtEP9pmc',
                    quantity: 1,
                },
            ],
            mode: 'payment',
        });
        // Faites quelque chose avec la session si nécessaire
        console.log(session);
        // Redirigez l'utilisateur vers la session de paiement Stripe
        window.location.href = session.url;
    } catch (error) {
        console.error(error);
    }
});
*/
/*
var elements = stripe.elements({

  });

  var expressCheckoutElement = elements.create('expressCheckout');

  console.log(expressCheckoutElement);
  */

  var stripe = Stripe("pk_test_51P0Nwr06cz5xLY6TQrioPb29OEZURuvoNUA1th0FYMIjJhPJvIoOjqOVnEsN2QTeCJRowOoc5UASb1KJ9L7RRKLc00jlWe9YJU");
  console.log(stripe);
  // var stripe = Stripe("pk_live_51P0Nwr06cz5xLY6T9QTYcf7LnL8DQf3lSBJgROLoFDCmXr1hZj5xQhOGSpMKguNYPXcRrEYdZH2Q0qsLwNPbqToX00nxuYkhkl"); 
  
  document.getElementById("checkout").addEventListener("click", function () {

      stripe.redirectToCheckout({
          lineItems: [
              {
                  // price: "price_1P0PU306cz5xLY6TzJi7YSHz", // Remplacez par l'ID de votre prix
                  price : "price_1PYkbM06cz5xLY6TCi12IS2K",
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
 