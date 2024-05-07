<?php
require_once('./../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `item_list` where id = '{$_GET['id']}' and `delete_flag` = 0 ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}

?>
<div class="container-fluid">
    <form action="" id="item-form">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="form-group">
            <label for="department" class="control-label">Department</label>
            <select name="department_id" id="department" class="form-control form-control-sm rounded-0"
                required="required" onchange="loadCategories()">
                <?php
                // Fetch department data
                $department_query = $conn->query("SELECT * FROM `department_list` WHERE delete_flag=0 and `status` = 1 AND loc_id=" . $_settings->userdata('loc_id') . "");
                while ($department_row = $department_query->fetch_assoc()) {
                    $selected = isset($department) && $department == $department_row['id'] ? 'selected' : '';
                    echo "<option value='{$department_row['id']}' {$selected}>{$department_row['name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="category_id" class="control-label">Category</label>
            <select name="category_id" id="category_id" class="form-control form-control-sm rounded-0"
                required="required">
                <option value="" <?= isset($category_id) ? 'selected' : '' ?>></option>
                <?php 
				$items = $conn->query("SELECT * FROM `category_list` where delete_flag = 0 and `status` = 1 AND loc_id=" . $_settings->userdata('loc_id') . "");
				while($row= $items->fetch_assoc()):
				?>
                <option value="<?= $row['id'] ?>"
                    <?= isset($category_id) && $category_id == $row['id'] ? 'selected' : '' ?>><?= $row['name'] ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="name" class="control-label">Name</label>
            <input type="text" name="name" id="name" class="form-control form-control-sm rounded-0"
                value="<?php echo isset($name) ? $name : ''; ?>" required />
        </div>
        <div class="form-group">
            <label for="unit" class="control-label">Unit</label>
            <select name="unit" id="unit" class="form-control form-control-sm rounded-0" required>
                <option value="" <?= isset($unit) ? '' : 'selected' ?>></option>
                <?php 
                $units = $conn->query("SELECT * FROM `inventory_units`");
                while($row = $units->fetch_assoc()):
                ?>
                <option value="<?= $row['unit_name'] ?>"
                    <?= isset($unit) && $unit == $row['unit_name'] ? 'selected' : '' ?>>
                    <?= $row['unit_name'] ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="vendor_id" class="control-label">Vendor</label>
            <select name="vendor_id" id="vendor_id" class="form-control form-control-sm rounded-0" required="required">
                <option value="" <?= isset($vendor_id) ? 'selected' : '' ?>></option>
                <?php 
                $vendors = $conn->query("SELECT * FROM `vendor_list`");
                while($row= $vendors->fetch_assoc()):
                ?>
                <option value="<?= $row['id'] ?>"
                    <?= isset($vendor_id) && $vendor_id == $row['id'] ? 'selected' : '' ?>><?= $row['vendor_name'] ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="rate_per_unit" class="control-label">Rate per Unit</label>
            <input type="text" name="rate_per_unit" id="rate_per_unit" class="form-control form-control-sm rounded-0"
                value="<?php echo isset($rate_per_unit) ? $rate_per_unit : ''; ?>" required />
        </div>

        <div class="form-group">
            <label for="safety_stock" class="control-label">Safety Stock</label>
            <input type="number" name="safety_stock" id="safety_stock" class="form-control form-control-sm rounded-0"
                value="<?php echo isset($safety_stock) ? $safety_stock : ''; ?>" required />
        </div>
        <div class="form-group">
            <label for="reorder_point" class="control-label">Reorder Point</label>
            <input type="number" name="reorder_point" id="reorder_point" class="form-control form-control-sm rounded-0"
                value="<?php echo isset($reorder_point) ? $reorder_point : ''; ?>" required />
        </div>

        <div class="form-group">
            <label for="description" class="control-label">Description</label>
            <textarea rows="3" name="description" id="description" class="form-control form-control-sm rounded-0"
                required><?php echo isset($description) ? $description : ''; ?></textarea>
        </div>
        <div class="form-group">
            <label for="status" class="control-label">Status</label>
            <select name="status" id="status" class="form-control form-control-sm rounded-0" required="required">
                <option value="1" <?= isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
                <option value="0" <?= isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>
        <!-- New Fields -->


    </form>
</div>
<script>
$(document).ready(function() {
    $('#uni_modal').on('shown.bs.modal', function() {
        $('#category_id').select2({
            placeholder: "Select Category Here",
            width: '100%',
            containerCssClass: 'form-control form-control-sm rounded-0',
            dropdownParent: $('#uni_modal')
        })
    })
    $('#department').on('change', function() {
        var departmentId = $(this).val();
        $.ajax({
            method: 'POST',
            url: _base_url_ + 'classes/Master.php?f=load_category',
            data: {
                department_id: departmentId
            },
            dataType: 'json',
            success: function(response) {
                $('#category_id').empty();

                // Loop through the response and add options to the category dropdown
                if (response && response.length > 0) {
                    $.each(response, function(index, category) {
                        $('#category_id').append('<option value="' + category.id +
                            '">' + category.name + '</option>');
                    });
                }
            },
            error: function(err) {
                console.log(err);
            }
        });
    });
    $('#item-form').submit(function(e) {
        e.preventDefault();
        var _this = $(this)
        $('.err-msg').remove();
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=save_item",
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            dataType: 'json',
            error: err => {
                console.log(err)
                alert_toast("An error occured", 'error');
                end_loader();
            },
            success: function(resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    // location.reload()
                    alert_toast(resp.msg, 'success')
                    uni_modal("<i class='fa fa-th-list'></i> item Details ",
                        "items/view_item.php?id=" + resp.iid)
                    $('#uni_modal').on('hide.bs.modal', function() {
                        location.reload()
                    })
                } else if (resp.status == 'failed' && !!resp.msg) {
                    var el = $('<div>')
                    el.addClass("alert alert-danger err-msg").text(resp.msg)
                    _this.prepend(el)
                    el.show('slow')
                    $("html, body").scrollTop(0);
                    end_loader()
                } else {
                    alert_toast("An error occured", 'error');
                    end_loader();
                    console.log(resp)
                }
            }
        })
    })

})
</script>