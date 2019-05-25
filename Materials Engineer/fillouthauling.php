<?php
    include "../db_connection.php";
?>
<!DOCTYPE html>

<html>

<head>
    <title>NGCBDC</title>
    <link rel="icon" type="image/png" href="Images/NGCB_logo.png">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="mx-auto mt-5 col-md-9">
        <div class="card">
            <div class="card-header">
                <h4>Hauling Receipt</h4>
            </div>
            <div class="card-body">
                <form class="form">
                    <div class="form-group row formnum-container">
                        <div class=" col-lg-12">
                            <label class="col-lg-12 col-form-label">Form No.:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="text" name="formNo">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row date-container">
                        <div class="col-lg-12">
                            <label class="col-lg-12 col-form-label">Date:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="date" name="haulingDate">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <label class="col-lg-2 col-form-label">Deliver to:</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="text" name="deliverTo">
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <label class="col-lg-2 col-form-label">Hauled from:</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="text" name="hauledFrom">
                        </div>
                    </div>
                    <div class="card">
                        <table class="table hauling-form-table">
                            <thead>
                                <tr>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Unit</th>
                                    <th scope="col">Articles</th>
                                </tr>
                            </thead>
                            <tbody id=haulingTable>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><input class="form-control" type="text" id="quantity" placeholder="Quantity">
                                    </td>
                                    <td><input class="form-control" type="text" id="unit" placeholder="Unit"></td>
                                    <td><input class="form-control" type="text" id="articles" placeholder="Articles">
                                    </td>
                                    <td colspan="5">
                                        <input type="button" class="btn btn-md btn-outline-secondary add-row" value="Add Row" />
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="form-group col-lg-6">
                            <label class="col-lg-12 col-form-label">Requested by:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="text" name="requestedBy">
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="col-lg-12 col-form-label">Hauled by:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="text" name="hauledBy">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="form-group col-lg-6">
                            <label class="col-lg-12 col-form-label">Warehouseman:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="text" name="warehouseman">
                            </div>
                            <label class="col-lg-12 col-form-label">Approved by:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="text" name="approvedBy">
                            </div>
                        </div>

                        <div class="form-group row col-lg-6">
                            <div class="card hauling-form-card">
                                <div class="card-header">
                                    <h5>TRUCK DETAILS</h5>
                                </div>
                                <div class="card-body form-group row col-lg-12">
                                    <label class="col-lg-4 col-form-label">Type:</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" name="type">
                                    </div>
                                    <label class="col-lg-4 col-form-label">Plate #:</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" name="plateNo">
                                    </div>
                                    <label class="col-lg-4 col-form-label">P.O./R.S. #:</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" names="PORS">
                                    </div>
                                    <label class="col-lg-4 col-form-label">Hauler ID:</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" name="haulerID">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group save-btn-container">
                        <div class="col-lg-12">
                            <input type="button" class="btn btn-primary" value="Save Changes">
                            <input type="reset" class="btn btn-secondary" value="Cancel">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".add-row").click(function () {
                var quantity = $("#quantity").val();
                var unit = $("#unit").val();
                var articles = $("#articles").val();
                var markup = "<tr><td>" + quantity +"</td><td>" + unit + "</td><td>" + articles +"</td><td><input type='button' class='btn btn-sm btn-outline-secondary delete-row' value='Delete' /></td></tr>";
                $("table tbody").append(markup);
            });

            $("#haulingTable").on('click','.delete-row',function(){
       $(this).closest('tr').remove();
     });
        });
    </script>
</body>

</html>