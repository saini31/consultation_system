<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultations</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <h1>Consultations</h1>

        <!-- Form to Schedule or Update Consultation -->
        <form id="consultationForm">
            @csrf
            <input type="hidden" id="consultation_id" name="consultation_id">
            <div>
                <label for="user_id">User ID:</label>
                <input type="number" id="user_id" name="user_id" required>
            </div>
            <div>
                <label for="professional_id">Professional ID:</label>
                <input type="number" id="professional_id" name="professional_id" required>
            </div>
            <div>
                <label for="scheduled_at">Scheduled At:</label>
                <input type="datetime-local" id="scheduled_at" name="scheduled_at" required>
            </div>
            <div>
                <label for="notes">Notes:</label>
                <textarea id="notes" name="notes"></textarea>
            </div>
            <button type="submit">Save Consultation</button>
            <button type="button" id="cancelUpdate" style="display: none;">Cancel Update</button>
        </form>

        <h2>Scheduled Consultations</h2>
        <table id="consultationTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Professional ID</th>
                    <th>Scheduled At</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Consultations will be dynamically inserted here -->
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            const apiUrl = '{{ url("api/consultations") }}';
            const postdata = '{{ url("api/consultations/store") }}';
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Handle form submission for create or update
            $('#consultationForm').on('submit', function(event) {
                event.preventDefault();
                const formData = $(this).serialize();
                const consultationId = $('#consultation_id').val();

                if (consultationId) {
                    // Update consultation
                    $.ajax({
                        url: `${apiUrl}/${consultationId}`,
                        method: 'PUT',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        success: function(data) {
                            if (data.consultation) {
                                updateConsultationInTable(data.consultation);
                                $('#consultationForm')[0].reset();
                                $('#cancelUpdate').hide();
                            } else {
                                console.error('Failed to update consultation', data);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                } else {
                    // Create consultation
                    $.ajax({
                        url: postdata,
                        method: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        success: function(data) {
                            if (data.consultation) {
                                addConsultationToTable(data.consultation);
                                $('#consultationForm')[0].reset();
                            } else {
                                console.error('Failed to schedule consultation', data);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                }
            });

            // Load consultations
            function loadConsultations() {
                $.ajax({
                    url: apiUrl,
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    },
                    success: function(data) {
                        console.log('Load Success:', data); // Debugging
                        if (data.consultations) {
                            data.consultations.forEach(consultation => addConsultationToTable(consultation));
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        console.error('Response:', xhr.responseText); // Debugging
                    }
                });
            }

            // Add consultation to the table
            function addConsultationToTable(consultation) {
                const row = `
                    <tr data-id="${consultation.id}">
                        <td>${consultation.id}</td>
                        <td>${consultation.user_id}</td>
                        <td>${consultation.professional_id}</td>
                        <td>${new Date(consultation.scheduled_at).toLocaleString()}</td>
                        <td>${consultation.notes || ''}</td>
                        <td>
                            <button onclick="editConsultation(${consultation.id})">Edit</button>
                            <button onclick="deleteConsultation(${consultation.id})">Delete</button>
                        </td>
                    </tr>
                `;
                $('#consultationTable tbody').append(row);
            }

            // Update consultation in the table
            function updateConsultationInTable(consultation) {
                const row = $(`#consultationTable tr[data-id="${consultation.id}"]`);
                row.find('td:eq(1)').text(consultation.user_id);
                row.find('td:eq(2)').text(consultation.professional_id);
                row.find('td:eq(3)').text(new Date(consultation.scheduled_at).toLocaleString());
                row.find('td:eq(4)').text(consultation.notes || '');
            }

            // Edit consultation
            window.editConsultation = function(id) {
                $.ajax({
                    url: `${apiUrl}/${id}`,
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    },
                    success: function(data) {
                        if (data.consultation) {
                            $('#consultation_id').val(data.consultation.id);
                            $('#user_id').val(data.consultation.user_id);
                            $('#professional_id').val(data.consultation.professional_id);
                            $('#scheduled_at').val(data.consultation.scheduled_at.replace(' ', 'T'));
                            $('#notes').val(data.consultation.notes || '');
                            $('#cancelUpdate').show();
                        } else {
                            console.error('Failed to fetch consultation', data);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            };

            // Delete consultation
            window.deleteConsultation = function(id) {
                $.ajax({
                    url: `${apiUrl}/${id}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    success: function(data) {
                        $(`#consultationTable tr[data-id="${id}"]`).remove();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            };

            // Cancel update operation
            $('#cancelUpdate').on('click', function() {
                $('#consultationForm')[0].reset();
                $('#consultation_id').val('');
                $(this).hide();
            });

            // Load consultations when the document is ready
            loadConsultations();
        });
    </script>
</body>

</html>