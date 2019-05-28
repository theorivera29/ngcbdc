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
    <div class="mx-auto col-md-10">
        <div class="card">
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
                            <label class="col-lg-12 col-form-label">Hauling Date:</label>
                            <div class="col-lg-12">
                                <input class="form-control" type="date" value="" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row col-lg-12">
                        <label class="col-lg-2 col-form-label">Hauled by:</label>
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
                                    <th scope="col">Returned Quantity</th>
                                    <th scope="col">Returned Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Returning Quantity</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>5</td>
                                    <td>pcs</td>
                                    <td>Jonelle</td>
                                    <td>3</td>
                                    <td>(mm/dd/yyyy)</td>
                                    <td>INC</td>
                                    <td> <input class="form-control" type="text" name="haulerID"></td>
                                    <td> <input type="button" class="btn btn-md btn-outline-secondary" value="Save" /></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>