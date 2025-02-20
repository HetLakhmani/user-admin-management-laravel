<x-app-layout>
    <div class="p-6 text-gray-900">
        <!-- <h2 class="text-lg font-semibold mb-4">Welcome to the Admin Dashboard!</h2> -->
        
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">

        <!-- Export Buttons -->
        <div class="mb-4">
            <button id="exportExcel" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-700">Export to Excel</button>
            <button id="exportCSV" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700">Export to CSV</button>
            <button id="exportPDF" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700">Export to PDF</button>
            <button id="printTable" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-700">Print</button>
        </div>

        <!-- User Table -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <table id="usersTable" class="display w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <!-- Edit User Modal -->
        <div id="editUserModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex justify-center items-center">
            <div class="bg-white p-6 rounded-lg w-1/3">
                <h2 class="text-lg text-black bg-green-600 font-semibold mb-4">Edit User</h2>
                <form id="updateUserForm">
                    <input type="hidden" id="editUserId" name="id">
                    
                    <div class="mb-4">
                        <label class="block text-gray-700">Name</label>
                        <input type="text" id="editName" name="name" class="w-full p-2 border rounded">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700">Email</label>
                        <input type="email" id="editEmail" name="email" class="w-full p-2 border rounded">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700">Role</label>
                        <select id="editRole" name="role" class="w-full p-2 border rounded">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    
                    <div class="flex justify-end space-x-2">
                        <button type="button" class="close-modal bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                        <button type="submit" class="text-black px-4 py-2 rounded">Update</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- jQuery & DataTables JS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

        <script>
            $(document).ready(function () {
                var table = $('#usersTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('users.data') }}",
                    columns: [
                        { data: 'id', name: 'id' },
                        { data: 'name', name: 'name' },
                        { data: 'email', name: 'email' },
                        { data: 'role', name: 'role' },
                        { data: 'actions', name: 'actions', orderable: false, searchable: false }
                    ],
                    dom: 'Bfrtip',
                    buttons: [
                        { extend: 'copyHtml5', text: 'Copy', className: 'hidden' },
                        { extend: 'excelHtml5', text: 'Export to Excel', className: 'hidden' },
                        { extend: 'csvHtml5', text: 'Export to CSV', className: 'hidden' },
                        { extend: 'pdfHtml5', text: 'Export to PDF', className: 'hidden' },
                        { extend: 'print', text: 'Print', className: 'hidden' }
                    ]
                });

                // Handle Edit Button Click
                $(document).on('click', '.edit-btn', function() {
                    var userId = $(this).data('id');

                    $.get('/admin/edit-user/' + userId, function(user) {
                        $('#editUserId').val(user.id);
                        $('#editName').val(user.name);
                        $('#editEmail').val(user.email);
                        $('#editRole').val(user.role);
                        $('#editUserModal').removeClass('hidden');
                    });
                });

                // Handle Update User
                $('#updateUserForm').submit(function(e) {
                    e.preventDefault();
                    var userId = $('#editUserId').val();

                    $.ajax({
                        url: '/admin/update-user/' + userId,
                        type: 'PUT',
                        data: $('#updateUserForm').serialize(),
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function(response) {
                            alert(response.message);
                            $('#editUserModal').addClass('hidden');
                            table.ajax.reload();
                        }
                    });
                });

                // Handle Delete Button Click
                $(document).on('click', '.delete-btn', function() {
                    var userId = $(this).data('id');

                    if (confirm('Are you sure you want to delete this user?')) {
                        $.ajax({
                            url: '/admin/delete-user/' + userId,
                            type: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            success: function(response) {
                                alert(response.message);
                                table.ajax.reload();
                            }
                        });
                    }
                });

                // Export Buttons
                $('#exportExcel').on('click', function() {
                    $('#usersTable').DataTable().button('.buttons-excel').trigger();
                });

                $('#exportCSV').on('click', function() {
                    $('#usersTable').DataTable().button('.buttons-csv').trigger();
                });

                $('#exportPDF').on('click', function() {
                    $('#usersTable').DataTable().button('.buttons-pdf').trigger();
                });

                $('#printTable').on('click', function() {
                    $('#usersTable').DataTable().button('.buttons-print').trigger();
                });

                // Close Modal
                $('.close-modal').click(function() {
                    $('#editUserModal').addClass('hidden');
                });
            });
        </script>
    </div>
</x-app-layout>
