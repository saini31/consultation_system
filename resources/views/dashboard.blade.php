<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}

                    <div class="container mx-auto mt-8 px-4">
                        <h1 class="text-3xl font-bold mb-6">Consultations</h1>

                        <!-- Form to Schedule or Update Consultation -->
                        <form id="consultationForm" class="bg-white shadow-md rounded-lg p-6 space-y-4">
                            @csrf
                            <input type="hidden" id="consultation_id" name="consultation_id">

                            <div class="flex flex-col space-y-2">
                                <label for="user_id" class="text-lg font-medium" style="color: black;">User ID:</label>
                                <input type="number" id="user_id" style="color: black;" name="user_id" required class="border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div class="flex flex-col space-y-2">
                                <label for="professional_id" class="text-lg font-medium" style="color: black;">Professional ID:</label>
                                <input type="number" id="professional_id" style="color: black;" name="professional_id" required class="border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div class="flex flex-col space-y-2">
                                <label for="scheduled_at" class="text-lg font-medium" style="color: black;">Scheduled At:</label>
                                <input type="datetime-local" style="color: black;" id="scheduled_at" name="scheduled_at" required class="border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div class="flex flex-col space-y-2">
                                <label for="notes" class="text-lg font-medium" style="color: black;">Notes:</label>
                                <textarea id="notes" style="color: black;" name="notes" class="border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>

                            <div class="flex space-x-4">
                                <button type="submit" style="color: black;" class="bg-blue-500 text-white rounded-lg px-4 py-2 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Save Consultation</button>
                                <button type="button" style="color: black;" id="cancelUpdate" class="bg-gray-300 text-gray-700 rounded-lg px-4 py-2 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">Cancel Update</button>
                            </div>
                        </form>

                        <h2 class="text-2xl font-bold mt-8">Scheduled Consultations</h2>
                        <table id="consultationTable" class="w-full mt-4 border border-gray-300 rounded-lg">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 border-b" style="color: black;">Consultation ID</th>
                                    <th class="px-4 py-2 border-b" style="color: black;">User ID</th>
                                    <th class="px-4 py-2 border-b" style="color: black;">Professional ID</th>
                                    <th class="px-4 py-2 border-b" style="color: black;">Scheduled At</th>
                                    <th class="px-4 py-2 border-b" style="color: black;">Notes</th>
                                    <th class="px-4 py-2 border-b" style="color: black;">Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                <!-- Consultations will be dynamically inserted here -->
                            </tbody>
                        </table>
                    </div>


                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <!-- Toastr CSS -->
                    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

                    <!-- Toastr JS -->
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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
                                                toastr.success('Consultation updated successfully.');
                                            } else {
                                                console.error('Failed to update consultation', data);
                                                toastr.error('Failed to update consultation.');
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            console.error('Error:', error);
                                            toastr.error('An error occurred. Please try again.');
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
                                                toastr.success('Consultation Sechedule successfully.');
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
                                        if (data.consultations) {
                                            data.consultations.forEach(consultation => addConsultationToTable(consultation));
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('Error:', error);
                                    }
                                });
                            }

                            // Add consultation to the table
                            function addConsultationToTable(consultation) {
                                const row = `
                                    <tr data-id="${consultation.id}" class="border-b hover:bg-red-50">
                                        <td  class="px-4 py-2 text-center">${consultation.id}</td>
                                        <td  class="px-4 py-2 text-center">${consultation.user_id}</td>
                                        <td  class="px-4 py-2 text-center">${consultation.professional_id}</td>
                                        <td  class="px-4 py-2 text-center">${new Date(consultation.scheduled_at).toLocaleString()}</td>
                                        <td  class="px-4 py-2">${consultation.notes || ''}</td>
                                        <td>
                                            <button onclick="editConsultation(${consultation.id})" class="bg-blue-500 text-white rounded-lg px-2 py-1 text-xs hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Edit</button>
                                            <button onclick="deleteConsultation(${consultation.id})" class="bg-red-500 text-white rounded-lg px-2 py-1 text-xs hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 ml-2">Delete</button>
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
                                        toastr.success('Consultation deleted successfully.');
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('Error:', error);
                                        toastr.error('Failed to delete consultation. Please try again.');
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
                        Echo.private(`App.Models.User.${userId}`)
                            .notification((notification) => {
                                console.log(notification.message);
                                alert(notification.message);
                            });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>