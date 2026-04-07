<section>
    <div class="container">
        <div class="row">

            <div class="col-lg-7 order-2 order-md-1">
                <figure class="login-img">
                    <img src="<?= base_url();?>assets/img/Login-rafiki.svg" alt="">
                </figure>
            </div>
            <div class="col-lg-5 order-1 order-md-2">

                <h3 class="text-center mb-5"> <i class="bi bi-card-list fs-4"></i> Registration Form</h3>
                <form method="POST" action="<?= site_url('save-registration-data');?>" onsubmit="return getPrg();">

                    <input type="text" id="name" name="name" class="form-control mb-3" placeholder="Student Name"
                        required>

                    <input type="text" id="contact" name="mobile" class="form-control mb-3" placeholder="Mobile No"
                        pattern="[7-9]{1}[0-9]{9}" maxlength="10" required>

                    <select id="schoolname" name="school" class="form-control mb-3" required>
                        <option value="">Select School</option>
                        <?php foreach($getSchool as $s){ ?>
                        <option value="<?= $s->school_name ?>">
                            <?= $s->school_name ?>
                        </option>
                        <?php } ?>
                    </select>

                    <!-- <select id="Integrated" name="class" class="form-control mb-3" onchange="getProgram(this.value)"
                        required>
                        <option value="">Select Class</option>
                        <php foreach($getclass as $c){ ?>
                        <option value="<= $c->class ?>">
                            <= $c->class ?>
                        </option>
                        <php } ?>
                    </select> -->

                    <!-- Program dropdown -->
                    <select name="class" id="class" class="form-control" onchange="getProgram(this.value)">
                        <option value="">Select Class</option>
                        <?php foreach($getclass as $c){ ?>
                        <option value="<?= $c->class ?>"><?= $c->class ?></option>
                        <?php } ?>
                    </select>

                    <!-- Program Section -->
                    <div class="program-box mb-3">
                        <label class="form-label fw-semibold">
                            Select Program <span class="text-danger">*</span>
                        </label>

                        <div id="programBox" class="program-placeholder">
                            <span class="text-muted">
                                Please select a class to see available programs
                            </span>
                        </div>
                    </div>


                    <div id="programBox" style="margin-top:10px;"></div>

                    <select name="academic_sess" class="form-control mb-3" required>
                        <option value="">Academic Session</option>
                        <option value="2024-25">2024-25</option>
                        <option value="2025-26">2025-26</option>
                        <option value="2026-27">2026-27</option>
                    </select>

                    <button type="submit" class="btn btn-primary w-100">
                        Register
                    </button>
                </form>



            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function getProgram(classId) {
    if (classId === '') {
        $('#programBox').html('');
        return;
    }

    $.ajax({
        type: 'POST',
        url: "<?= site_url('getProgramData');?>",
        data: {
            class: classId
        },
        success: function(res) {
            $('#programBox').html(res);
        }
    });
}
</script>

<script>
function getPrg() {
    if ($('input[name="program_name[]"]:checked').length === 0) {
        alert('Please select at least one program');
        return false;
    }
    return true;
}
</script>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>



<!-- <script>
const chBoxes =
    document.querySelectorAll('.dropdown-menu input[type="checkbox"]');
const dpBtn =
    document.getElementById('multiSelectDropdown');
let mySelectedListItems = [];

function handleCB() {
    mySelectedListItems = [];
    let mySelectedListItemsText = '';

    chBoxes.forEach((checkbox) => {
        if (checkbox.checked) {
            mySelectedListItems.push(checkbox.value);
            mySelectedListItemsText += checkbox.value + ', ';
        }
    });

    dpBtn.innerText =
        mySelectedListItems.length > 0 ?
        mySelectedListItemsText.slice(0, -2) : 'Select';
}

chBoxes.forEach((checkbox) => {
    checkbox.addEventListener('change', handleCB);
});
</script> -->