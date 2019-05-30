<?php
    include "../db_connection.php";
?>
<!DOCTYPE html>

<html>

<head>
    <title>NGCBDC</title>
    <link rel="icon" type="image/png" href="../Images/login2.png">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <script src="../JS/jquery/jquery-3.4.1.min.js"></script>
    <script src="../JS/popper/popper.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="mx-auto mt-5 col-md-10">
        <div class="card">
            <div class="card-header">
                <h4>Delivered Materials</h4>
            </div>
            <div class="card-body">
                <form class="form needs-validation" action="../server.php" method="POST" novalidate>
                    <div class="form-group row date-container">
                        <div class="col-lg-12">
                            <label class="col-lg-12 col-form-label">Date:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="date" name="deliveredDate" required>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <label class="col-lg-2 col-form-label">Project:</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="text" name="project">
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <label class="col-lg-2 col-form-label">Location:</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="text" name="location">
                        </div>
                    </div>
                    <div class="card">
                        <table class="table hauling-form-table">
                            <thead>
                                <tr>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Unit</th>
                                    <th scope="col">Articles</th>
                                    <th scope="col">Supplied By</th>
                                    <th scope="col">From</th>
                                </tr>
                            </thead>
                            <tbody id=deliveredTable>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><input class="form-control" name="quantity" type="text" id="quantity" placeholder="Quantity" required>
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                    </td>
                                    <td><input class="form-control" name="unit" type="text" id="unit" placeholder="Unit" required>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </td>
                                    <td><input class="form-control" name="articles" type="text" id="articles"
                                            placeholder="Articles" required>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </td>
                                    <td><input class="form-control" name="suppliedBy" type="text" id="suppliedBy"
                                            placeholder="Supplied By" required>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control" name="from" id="selectFrom" required>
                                                <option value="">Choose</option>
                                                <option value="1">Main Office</option>
                                                <option value="2">Petty Cash</option>
                                            </select>
                                            <div class="invalid-feedback">Please fill out this field.</div>
                                        </div>
                                    </td>
                                    <td colspan="5">
                                        <input type="button" class="btn btn-md btn-outline-secondary add-row"
                                            value="Add Row" />
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="row form-group save-btn-container">
                        <div class="col-lg-12">
                            <input type="submit" name="create_deliveredin" class="btn btn-primary" value="Save Changes">
                            <input type="reset" class="btn btn-secondary" value="Cancel">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $(".add-row").click(function () {
                var quantity = $("#quantity").val();
                var unit = $("#unit").val();
                var articles = $("#articles").val();
                var suppliedBy = $("#suppliedBy").val();
                var selectFrom = $("#selectFrom option:selected").val();
                var markup = "<tr><td>" + quantity + "</td><td>" + unit + "</td><td>" + articles +
                    "</td><td>" + suppliedBy +
                    "</td><td>" + selectFrom +
                    "</td><td><input type='button' class='btn btn-sm btn-outline-secondary delete-row' value='Delete' /></td></tr>";
                $("table tbody").append(markup);
            });

            $("#deliveredTable").on('click', '.delete-row', function () {
                $(this).closest('tr').remove();
            });
        });

        (function () {
            'use strict';
            window.addEventListener('load', function () {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</body>

</html>