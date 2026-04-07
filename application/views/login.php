<section>
    <div class="container">
        <div class="row">

            <div class="col-lg-7 order-2 order-md-1">
                <figure class="login-img">
                    <img src="<?= base_url();?>assets/img/Login-rafiki.svg" alt="">
                </figure>
            </div>
            <div class="col-lg-5 order-1 order-md-2">

                <h3 class="text-center mb-5"><i class="bi bi-person-circle fs-4"></i> Login </h3>
                <!-- <form class="form" method="POST" action="<?= site_url('student-login');?>">
                    <div class="mb-3">
                        <input type="number" class="form-control" id="contact" placeholder="Mobile Number" required
                            name="mobile">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>

                </form> -->

                <form class="form" method="POST" action="<?= site_url('student-login'); ?>">

                    <div class="mb-3">
                        <input type="number" class="form-control" placeholder="Mobile Number" required name="mobile">
                    </div>

                    <div class="mb-3">
                        <select class="form-control" name="academic_sess" required>
                            <option value="">Select Academic Year</option>
                            <option value="2024-25">2024-25</option>
                            <option value="2025-26">2025-26</option>
                            <option value="2026-27">2026-27</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Login</button>

                </form>


            </div>
        </div>
    </div>
</section>