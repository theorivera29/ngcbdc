<!DOCTYPE html>

<html>

<head>
    <title>NGCBDC</title>
    <link rel="icon" type="image/png" href="Images/NGCB_logo.png">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script rel="stylesheet" src="../Libraries/dataTables.select.min.js" crossorigin="anonymous"></script>
    <script rel="stylesheet" src="../Libraries/jquery-3.3.1.js" crossorigin="anonymous"></script>
    <script rel="stylesheet" src="../Libraries/jquery.dataTables.min.js" crossorigin="anonymous"></script>
</head>

<body>
    <section id="tabs">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 project-tabs">
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                role="tab" aria-controls="nav-home" aria-selected="true">SITE MATERIALS</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                role="tab" aria-controls="nav-profile" aria-selected="false">CATEGORY</a>
                        </div>
                    </nav>
                </div>
                <div class="view-inventory-tabs-content">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                            aria-labelledby="nav-home-tab">
                            <table id="example" class="table table-striped table-bordered view-inventory-table">
                                <thead>
                                    <tr>
                                        <th>Particulars</th>
                                        <th>Category</th>     
                                        <th>Previous Material Stock</th>
                                        <th>Unit</th>
                                        <th>Delivered Material as of May 2019</th>
                                        <th>Material pulled out as of May 2019</th>
                                        <th>Unit</th>
                                        <th>Accumulated Materials Delivered</th>
                                        <th>Material on site as of May 2019</th>
                                        <th>Unit</th>
                                        <th>Project</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-group custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                <label class="custom-control-label" for="customCheck1"></label>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Particulars</th>
                                        <th>Category</th>     
                                        <th>Previous Material Stock</th>
                                        <th>Unit</th>
                                        <th>Delivered Material as of May 2019</th>
                                        <th>Material pulled out as of May 2019</th>
                                        <th>Unit</th>
                                        <th>Accumulated Materials Delivered</th>
                                        <th>Material on site as of May 2019</th>
                                        <th>Unit</th>
                                        <th>Project</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="card project-container">
                            <h5 class="card-header card-header-project">PROJECT NAME</h5>
                            <div class="card-body">
                                <span>
                                    <h5>Address</h5>
                                </span>
                                <span>
                                    <h5>Start Date:</h5>
                                </span>
                                <span>
                                    <h5>End Date:</h5>
                                </span>
                                <button type="button" class="btn btn-info" id="view-inventory-btn" type="button">View
                                    inventory</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

</body>
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            }],
            select: {
                style: 'os',
                selector: 'td:first-child'
            },
            order: [
                [1, 'asc']
            ]
        });
    });
</script>

</html>