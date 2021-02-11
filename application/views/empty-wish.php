<section class="no-itam-cart">
    <div class="container">
        <div class="no-itam-cart-in">
            <img src="<?= base_url(); ?>assets/images/dr-login.svg" class="cart-img">
            <h3><?= isset($data) ? "YOUR WISHLIST IS EMPTY" : "PLEASE LOG IN" ?></h3>
     
            <p><?= isset($data) ? "Add items that you like to your wishlist. Review them anytime and easily move them to the bag." : "Login to view items in your wishlist." ?></p>
            <button onclick=window.location.href='<?= isset($data) ? base_url() : base_url("Myaccount") ?>'><?= isset($data) ? "Continue Shopping" : "Login" ?></button>


        </div>
    </div>
</section>