<!DOCTYPE html>

<html>

<head>
    <title>NGCBDC</title>
    <link rel="icon" type="image/png" href="Images/NGCB_logo.png">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" href="../bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
</head>

<body>
    <button class="btn btn-warning generate-hauling-btn" type="button">Generate Hauling
        Receipt</button>
    <div class="mx-auto">
        <div class="card view-hauling-receipt-container">
            <div class="card-header">
                <div class="row col-lg-12">
                    <div class="col-lg-8">
                        <h4>Hauling Receipt</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form">
                    <div class="form-group row formnum-container">
                        <div class=" col-lg-12">
                            <label class="col-lg-12 col-form-label">Form No.:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="text" value="" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row date-container">
                        <div class="col-lg-12">
                            <label class="col-lg-12 col-form-label">Date:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="date" value="" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <label class="col-lg-2 col-form-label">Deliver to:</label>
                        <div class="col-lg-10">
                            <input class="form-control" type="text" value="" disabled>
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <label class="col-lg-2 col-form-label">Hauled from:</label>
                        <div class="col-lg-10">
                            <input class="form-control" type="text" value="" disabled>
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
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="form-group col-lg-6">
                            <label class="col-lg-12 col-form-label">Requested:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="text" value="" disabled>
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="col-lg-12 col-form-label">Hauled by:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="text" value="" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="form-group col-lg-6">
                            <label class="col-lg-12 col-form-label">Warehouseman:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="text" value="" disabled>
                            </div>
                            <label class="col-lg-12 col-form-label">Approved by:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="text" value="" disabled>
                            </div>
                        </div>

                        <div class="form-group row col-lg-6">
                            <div class="card hauling-form-card">
                                <div class="card-header">
                                    <h5>TRUCK DETAILS</h5>
                                </div>
                                <div class="card-body form-group row col-lg-12">
                                    <label class="col-lg-4 col-form-label">Type:</label>
                                    <div class="col-lg-8 form-group">
                                        <input class="form-control" type="text" value="" disabled>
                                    </div>
                                    <label class="col-lg-4 form-group col-form-label">Plate #:</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" value="" disabled>
                                    </div>
                                    <label class="col-lg-4 form-group col-form-label">P.O./R.S. #:</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" value="" disabled>
                                    </div>
                                    <label class="col-lg-4 form-group col-form-label">Hauler ID:</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="text" value="" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>