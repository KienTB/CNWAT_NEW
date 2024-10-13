<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Menu</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="#" onclick="loadPage('DrawTable')">Draw Table</a></li>
            <li><a href="#" onclick="loadPage('Loop')">Loop</a></li>
            <li><a href="#" onclick="loadPage('CalculationForm')">Calculate</a></li>
            <li><a href="#" onclick="loadPage('CalculateTotalScore')">Calculate Total Score</a></li>
            <li><a href="#" onclick="loadPage('Array1D')">1D Array</a></li>
            <li><a href="#" onclick="loadPage('Matrix')">Matrix</a></li>
            <li><a href="#" onclick="loadPage('UploadFile')">Upload File</a></li>
            <li><a href="#" onclick="loadPage('ListOfUsers')">List of Users</a></li>
            <li><a href="#" onclick="loadPage('AddUser')">Add User</a></li>
            <li><a href="#" onclick="loadPage('EditUser')">Edit User</a></li>
            <li><a href="#" onclick="loadPage('DeleteUser')">Delete User</a></li>
            <li><a href="#" onclick="loadPage('AddStudentFile')">Add Student File</a></li>
            <li><a href="#" onclick="loadPage('ListStudentFiles')">List Student Files</a></li>
        </ul>
    </nav>

    <script>
        function loadPage(page) {
            // Chuyển hướng đến trang với tên tương ứng trong tham số `page`.
            window.location.href = "../index/index.php?page=" + encodeURIComponent(page);
        }
    </script>
</body>
</html>
