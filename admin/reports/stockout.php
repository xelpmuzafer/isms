<?php 
$start_date = isset($_GET['start_date']) ? date('Y-m-01', strtotime($_GET['start_date'])) : date('Y-m-01');
$end_date = isset($_GET['end_date']) ? date('Y-m-t', strtotime($_GET['end_date'])) : date('Y-m-t');
$item_id = isset($_GET['item_id']) ? $_GET['item_id'] : null;
?>
<div class="content py-5 px-3 bg-teal">
    <h2>Monthly Stock-Out Reports</h2>
</div>
<div class="row flex-column mt-4 justify-content-center align-items-center mt-lg-n4 mt-md-3 mt-sm-0">
    <div class="col-lg-11 col-md-11 col-sm-12 col-xs-12">
        <div class="card rounded-0 mb-2 shadow">
            <div class="card-body">
                <fieldset>
                    <legend>Filter</legend>
                    <form action="" id="filter-form">
                        <div class="row align-items-end">
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="start_date" class="control-label">Start Date</label>
                                    <input type="date" class="form-control form-control-sm rounded-0" name="start_date"
                                    id="start_date" value="<?= $start_date ?>" required="required">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="end_date" class="control-label">End Date</label>
                                    <input type="date" class="form-control form-control-sm rounded-0" name="end_date"
                                        id="end_date" required="required" value="<?= $end_date ?>">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="item_id" class="control-label">Select Item</label>
                                    <select name="item_id" id="item_id" class="form-control form-control-sm rounded-0">
                                        <option value="" <?= empty($item_id) ? 'selected' : '' ?>>Select Item</option>
                                        <?php
                                    $items = $conn->query("SELECT * FROM `item_list` where delete_flag = 0 AND loc_id=" . $_settings->userdata('loc_id') . " ");
                                    while ($item = $items->fetch_assoc()):
                                    ?>
                                        <option value="<?= $item['id'] ?>"
                                            <?= ($item_id == $item['id']) ? 'selected' : '' ?>>
                                            <?= $item['name'] ?>
                                        </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <button class="btn btn-sm btn-flat btn-primary bg-gradient-primary"><i
                                            class="fa fa-filter"></i> Filter</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
    <div class="col-lg-11 col-md-11 col-sm-12 col-xs-12">
        <div class="card rounded-0 mb-2 shadow">
            <div class="card-header py-1">
                <div class="card-tools">
                    <button class="btn btn-flat btn-sm btn-light bg-gradient-light border text-dark" type="button" 
                    id="print"><i class="fa fa-print"></i> Print</button>
                </div>
            </div>
            <div class="card-body">
                <div class="container-fluid" id="printout">
                    <table class="table table-bordered">
                        <colgroup>
                            <col width="10%">
                            <col width="15%">
                            <col width="30%">
                            <col width="15%">
                            <col width="30%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="px-1 py-1 text-center">#</th>
                                <th class="px-1 py-1 text-center">Date</th>
                                <th class="px-1 py-1 text-center">Item</th>
                                <th class="px-1 py-1 text-center">Quantity</th>
                                <th class="px-1 py-1 text-center">Rate</th>
                                <th class="px-1 py-1 text-center">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $g_total = 0;
                            $i = 1;
                            $stock = $conn->query("SELECT s.*, i.name as `item`, c.name as `category`, i.unit FROM `stockout_list` s 
                            inner join `item_list` i on s.item_id = i.id 
                            inner join category_list c on i.category_id = c.id 
                            where (s.date BETWEEN '{$start_date}' AND '{$end_date}')
                            AND (s.item_id = '{$item_id}' OR '{$item_id}' = '')
                            order by date(s.`date`) asc");
                            while($row = $stock->fetch_assoc()):

                            ?>
                            <tr>
                                <td class="px-1 py-1 align-middle text-center"><?= $i++ ?></td>
                                <td class="px-1 py-1 align-middle"><?= date("F d, Y", strtotime($row['date'])) ?></td>
                                <td class="px-1 py-1 align-middle">
                                    <div line-height="1em">
                                        <div class="font-weight-bold"><?= $row['item'] ?> [<?= $row['unit'] ?>]</div>
                                        <div class="font-weight-light"><?= $row['category'] ?></div>
                                    </div>
                                </td>
                                <td class="px-1 py-1 align-middle text-right"><?= format_num($row['quantity']) ?></td>
                                <td class="px-1 py-1 align-middle text-right"><?= format_num($row['rate']) ?></td>
                                <td class="px-1 py-1 align-middle"><?= $row['remarks'] ?></td>
                                
                            </tr>
                            <?php endwhile; ?>
                            <?php if($stock->num_rows <= 0): ?>
                                <tr>
                                    <td class="py-1 text-center" colspan="5">No records found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<noscript id="print-header">
    <div>
        <style>
            html{
                min-height:unset !important;
            }
        </style>
        <div class="d-flex w-100 align-items-center">
            <div class="col-2 text-center">
                <img src="<?= validate_image($_settings->info('logo')) ?>" alt="" class="rounded-circle border" 
                style="width: 5em;height: 5em;object-fit:cover;object-position:center center">
            </div>
            <div class="col-8">
                <div style="line-height:1em">
                    <div class="text-center font-weight-bold h5 mb-0">
                        <large><?= $_settings->info('name') ?></large>
                    </div>
                    <div class="text-center font-weight-bold h5 mb-0">
                        <large>Monthly Stock-Out Report</large>
                    </div>
                    <div class="text-center font-weight-bold h5 mb-0">as of <?= date("F Y", strtotime($month."-01")) ?>
                </div>
                </div>
            </div>
        </div>
        <hr>
    </div>
</noscript>
<script>
    function print_r(){
        var h = $('head').clone()
        var el = $('#printout').clone()
        var ph = $($('noscript#print-header').html()).clone()
        h.find('title').text("Monthly Stock-Out Report - Print View")
        var nw = window.open("", "_blank", "width="+($(window).width() * .8)+",left="+($(window).width() * .1)+
            ",height="+($(window).height() * .8)+",top="+($(window).height() * .1))
            nw.document.querySelector('head').innerHTML = h.html()
            nw.document.querySelector('body').innerHTML = ph[0].outerHTML
            nw.document.querySelector('body').innerHTML += el[0].outerHTML
            nw.document.close()
            start_loader()
            setTimeout(() => {
                nw.print()
                setTimeout(() => {
                    nw.close()
                    end_loader()
                }, 200);
            }, 300);
    }
    $(function(){
        $('#filter-form').submit(function(e){
            e.preventDefault()
            location.href = './?page=reports/stockout&'+$(this).serialize()
        })
        $('#print').click(function(){
            print_r()
        })

    })
</script>