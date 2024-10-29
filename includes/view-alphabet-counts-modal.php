<?php
    $base_url = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/photo_abcd_A/';

    if (!isset($_SESSION['current_user_email']) || !isset($_SESSION['current_user_role']) || $_SESSION['current_user_role'] !== 'admin') {
        header('Location: ' . $base_url . 'index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alphabet Counts Modal</title>
    <link href="css/tables.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/jquery.dataTables.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/jquery.dataTables.min.js"></script>
</head>
<body>

<div id="viewAlphabetCountsModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="viewAlphabetCountsForm">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">View Alphabet Book Counts</h3>
                    <button type="button" class="btn btn-primary" onclick="exitViewAlphabetCounts()">Exit</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="userFullName" class="col-sm-1 col-form-label">User: </label>
                        <div class="col-sm-8">
                            <input id="userFullName" class="form-control-plaintext" readonly>
                        </div>
                    </div>
                    <div>
                        <table id="alphabetCountsTable" class="display">
                            <thead>
                                <tr id="header">
                                    <th>Letter</th>
                                    <th>Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Populated with AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showAlphabetCountsModal(email) {
        // Clear the table
        $('#alphabetCountsTable tbody').empty();

        // Destroy the DataTable instance if it exists
        if ($.fn.dataTable.isDataTable('#alphabetCountsTable')) {
            $('#alphabetCountsTable').DataTable().clear().destroy();
        }

        $.ajax({
            url: 'actions/get-alphabet-counts-for-admin.php',
            type: 'GET',
            data: { email: email },  // Send the email
            dataType: 'json',
            success: function(response) {
                if (Array.isArray(response) && response.length > 0) {
                    response.forEach(function(row) {
                        $('#alphabetCountsTable tbody').append(
                            '<tr><td>' + row.Letter + '</td><td>' + row.LetterCount + '</td></tr>'
                        );
                    });

                    // Re-initialize DataTable after populating the table
                    $('#alphabetCountsTable').DataTable();
                    $('#viewAlphabetCountsModal').modal('show'); // Show the modal
                } else {
                    console.warn('No data returned for the given email.');
                    $('#viewAlphabetCountsModal').modal('show'); // Show the modal even if there's no data
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data:", error);
            }
        });
    }


    function exitViewAlphabetCounts() {
        $('#viewAlphabetCountsModal').modal('hide');
    }
</script>

</body>
</html>
