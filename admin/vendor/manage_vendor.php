<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['id'])) {
    $user = $conn->query("SELECT * FROM vendor_list WHERE id = '{$_GET['id']}' ");
    $meta = array(); // Initialize $meta array
    foreach ($user->fetch_array() as $k => $v) {
        $meta[$k] = $v;
    }
}
?>

<?php if ($_settings->chk_flashdata('success')): ?>
<script>
alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success');
</script>
<?php endif; ?>

<div class="card card-outline rounded-0 card-teal">
    <div class="card-body">
        <div class="container-fluid">
            <div id="msg"></div>
            <form action="" id="manage-user">
                <input type="hidden" name="id" value="<?= isset($meta['id']) ? $meta['id'] : '' ?>">
                <div class="form-group">
                    <label for="name">Vendor Name</label>
                    <input type="text" name="vendor_name" id="vendor_name" class="form-control"
                        value="<?php echo isset($meta['vendor_name']) ? $meta['vendor_name']: '' ?>" required>
                </div>
                <div class="form-group">
                    <label for="vendor_type">Vendor Type</label>
                    <select name="vendor_type" id="selection_type" class="form-control">
                        <option value="Regular">Regular</option>
                        <option value="One Time">One-time</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">GST No</label>
                    <input type="text" name="gst_no" id="gst_no" class="form-control"
                        value="<?php echo isset($meta['gst_no']) ? $meta['gst_no']: '' ?>">
                </div>

                <div class="form-group">
                    <label for="username">Contact Person</label>
                    <input type="text" name="contacr_person" id="contacr_person" class="form-control"
                        value="<?php echo isset($meta['contacr_person']) ? $meta['contacr_person']: '' ?>" required
                        autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="username">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control"
                        value="<?php echo isset($meta['phone']) ? $meta['phone']: '' ?>" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="username">Address</label>
                    <input type="text" name="address" id="address" class="form-control"
                        value="<?php echo isset($meta['address']) ? $meta['address']: '' ?>" required
                        autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="username">Other Details</label>
                    <input type="text" name="other_details" id="other_details" class="form-control"
                        value="<?php echo isset($meta['other_details']) ? $meta['other_details']: '' ?>">
                </div>

            </form>
        </div>
    </div>
    <div class="card-footer">
        <div class="col-md-12">
            <div class="row">
                <button class="btn btn-sm btn-primary rounded-0 mr-3" form="manage-user">Save User Details</button>
                <a href="./?page=vendor/list" class="btn btn-sm btn-default border rounded-0"><i
                        class="fa fa-angle-left"></i> Cancel</a>
            </div>
        </div>
    </div>
</div>

<style>
img#cimg {
    height: 15vh;
    width: 15vh;
    object-fit: cover;
    border-radius: 100% 100%;
}
</style>

<script>
$('#manage-user').submit(function(e) { // Changed form ID to "manage-user"
    e.preventDefault();
    start_loader();
    $.ajax({
        url: _base_url_ + 'classes/Vendors.php?f=save',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {
            if (resp == 1) {
                location.href = './?page=vendor/list';
            } else {
                $('#msg').html('<div class="alert alert-danger">Vendor already exists</div>');
                end_loader();
            }
        }
    });
});
</script>