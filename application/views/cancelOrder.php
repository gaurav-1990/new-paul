<div class="container">
    <div class="condition">
        <div class="col-lg-12 col-md-12">
            <h1 class="content-title">Select Reason for Cancellation </h1>
            <div class="text-block">

                <form method="POST" action="<?= base_url('Myaccount/cancelRequest'); ?>">
                    <p>
                        <label class="radio-inline">
                            <input type="radio" value="I received a wrong product." name="optradio" checked> I received a wrong product.
                        </label>
                    </p>
                    <p>
                        <label class="radio-inline">
                            <input type="radio" value=" received a damaged product." name="optradio"> I received a damaged product.
                        </label>
                    </p>
                    <p>
                        <label class="radio-inline">
                            <input type="radio"  value="Got product delivery too late." name="optradio"> Got product delivery too late.
                        </label>
                    </p>
                    <p>
                        <label class="radio-inline">
                            <input type="radio"  value="I didn't liked product." name="optradio"> I didn't like product.
                        </label>
                    </p>
                    <input type="hidden" name="data" value="<?= $this->uri->segment(3); ?>" />
                    <div class="form-group">
                        <label class="radio-inline">
                            <input value="Other" type="radio" name="optradio"> Other
                        </label>
                        <textarea rows="10" name="Reason" class="form-control" ></textarea>
                    </div>
                    <div class="form-group">
                        <button type="Submit">Submit</button>
                    </div>

                </form>


            </div>













        </div>

    </div>
</div>
