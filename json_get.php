<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>API Data Display</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container my-5">
        <h2 class="mb-4">API Data Display</h2>

        <?php
        // API URL (Dummy Example)
        $url = "https://reqres.in/api/users?page=2";
        $response = file_get_contents($url);
        // print_r($response);
        $data = json_decode($response, true);
        echo "<pre>";
        // print_r($data);
        echo "</pre>";
        // Check if data exists
        if (isset($data['data'])) {
            echo '<table class="table table-bordered table-striped">';
            echo '<thead class="table-dark">';
            echo '<tr><th>ID</th><th>Name</th><th>Email</th><th>Avatar</th></tr>';
            echo '</thead><tbody>';

            foreach ($data['data'] as $user) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($user['id']) . '</td>';
                echo '<td>' . htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) . '</td>';
                echo '<td>' . htmlspecialchars($user['email']) . '</td>';
                echo '<td><img src="' . htmlspecialchars($user['avatar']) . '" width="50" height="50" class="rounded-circle"></td>';
                echo '</tr>';
            }

            echo '</tbody></table>';
        } else {
            echo '<div class="alert alert-danger">No Data Found</div>';
        }
        ?>
    </div>

</body>

</html>



<?php
$url = "https://reqres.in/api/users?page=2";

// Initialize cURL
$ch = curl_init($url);

// Return response instead of outputting
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute cURL request
$response = curl_exec($ch);

// Close cURL session
curl_close($ch);

// Decode JSON response
$data = json_decode($response, true);

// Output the result
echo "<pre>";
print_r($data);
echo "</pre>";
?>


