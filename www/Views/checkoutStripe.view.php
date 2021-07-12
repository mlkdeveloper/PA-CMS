
<section>
    <div class="container">
        <div class="row">
            <div class="col col-lg-12">
                <h1 style="text-align: center;font-size: 40px">Processus de paiement</h1>
                <div class="jumbotron">
                    <div class="product">
                        <img
                                src="https://i.imgur.com/EHyR2nP.png"
                                alt="The cover of Stubborn Attachments"
                        />
                        <div class="description">
                            <h3>Stubborn Attachments</h3>
                            <h5>€40.00</h5>
                        </div>
                    </div>
                    <button type="button" id="checkout-button">Checkout</button>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
<script type="text/javascript">
    // Create an instance of the Stripe object with your publishable API key
    var stripe = Stripe("pk_test_51JC0puGueu1Z1r2S3oq9aEovJmlKpYwQ8isyViEyKtwQrLXIEZBdOVeXiihXPpi4EtJHkTd53Whc5F6J7TNxLEQz00XaTk67k0");
    var checkoutButton = document.getElementById("checkout-button");

    checkoutButton.addEventListener("click", function () {
        fetch("/create-checkout-session", {
            method: "POST",
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (session) {
                return stripe.redirectToCheckout({ sessionId: session.id });
            })
            .then(function (result) {
                // If redirectToCheckout fails due to a browser or network
                // error, you should display the localized error message to your
                // customer using error.message.
                if (result.error) {
                    alert(result.error.message);
                }
            })
            .catch(function (error) {
                console.error("Error:", error);
            });
    });
</script>
</html>