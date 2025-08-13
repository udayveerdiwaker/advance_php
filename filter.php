<?php
// Result array
$result = [];
$errors = [];

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 1️⃣ Name - Sanitization
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    $result['name'] = $name;

    // 2️⃣ Email - Sanitization + Validation
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }
    $result['email'] = $email;

    // 3️⃣ Age - Validation (integer)
    $age = filter_var($_POST['age'], FILTER_VALIDATE_INT);
    if ($age === false) {
        $errors[] = "Age must be a number.";
    }
    $result['age'] = $age;

    // 4️⃣ Website - Optional Validation
    $website = filter_var($_POST['website'], FILTER_SANITIZE_URL);
    if (!empty($website) && !filter_var($website, FILTER_VALIDATE_URL)) {
        $errors[] = "Invalid website URL.";
    }
    $result['website'] = $website;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhanced Form Validation | PHP Filter Example</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --success: #06d6a0;
            --danger: #ef476f;
            --warning: #ffd166;
            --dark: #073b4c;
            --light: #f8f9fa;
            --gray: #6c757d;
            --card-shadow: 0 10px 20px rgba(0, 0, 0, 0.05), 0 6px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            padding: 20px;
        }

        .header h1 {
            font-size: 2.5rem;
            color: var(--dark);
            margin-bottom: 10px;
            background: linear-gradient(90deg, var(--primary), var(--dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .header p {
            color: var(--gray);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            margin-bottom: 30px;
            transition: var(--transition);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: linear-gradient(90deg, var(--primary), #3a86ff);
            color: white;
            padding: 20px;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .card-body {
            padding: 30px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark);
        }

        .form-control {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .form-control::placeholder {
            color: #a0aec0;
        }

        .btn {
            display: inline-block;
            background: linear-gradient(90deg, var(--primary), #3a86ff);
            color: white;
            border: none;
            padding: 14px 28px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 10px;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 6px rgba(67, 97, 238, 0.3);
            margin-top: 10px;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 14px rgba(67, 97, 238, 0.4);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn i {
            margin-right: 10px;
        }

        .errors {
            background-color: #fff5f5;
            border-left: 4px solid var(--danger);
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 0 8px 8px 0;
        }

        .errors h3 {
            color: var(--danger);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .errors h3 i {
            margin-right: 10px;
        }

        .error-item {
            display: flex;
            align-items: center;
            padding: 8px 0;
            font-size: 1.05rem;
        }

        .error-item i {
            color: var(--danger);
            margin-right: 10px;
            min-width: 20px;
        }

        .success {
            background-color: #f0fff4;
            border-left: 4px solid var(--success);
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 0 8px 8px 0;
            display: flex;
            align-items: center;
        }

        .success i {
            color: var(--success);
            font-size: 1.8rem;
            margin-right: 15px;
        }

        .success div h3 {
            color: var(--success);
            margin-bottom: 5px;
        }

        .result-box {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 25px;
            border-radius: 12px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .result-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .result-item {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
        }

        .result-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 14px rgba(0, 0, 0, 0.1);
        }

        .result-item h4 {
            color: var(--gray);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .result-item p {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark);
            word-break: break-word;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            color: var(--gray);
            font-size: 0.9rem;
        }

        .footer a {
            color: var(--primary);
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }

            .card-body {
                padding: 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .btn {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 15px;
            }

            .header h1 {
                font-size: 1.8rem;
            }

            .header p {
                font-size: 1rem;
            }

            .card-header {
                font-size: 1.3rem;
                padding: 15px;
            }

            .form-control {
                padding: 12px 14px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Enhanced Form Validation</h1>
            <p>PHP form with modern UI/UX design and responsive layout</p>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="fas fa-user-circle"></i> Personal Information
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name"><i class="fas fa-user"></i> Full Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name" required>
                        </div>

                        <div class="form-group">
                            <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                        </div>

                        <div class="form-group">
                            <label for="age"><i class="fas fa-birthday-cake"></i> Age</label>
                            <input type="number" name="age" id="age" class="form-control" placeholder="Enter your age" min="1" max="120" required>
                        </div>

                        <div class="form-group">
                            <label for="website"><i class="fas fa-globe"></i> Website (Optional)</label>
                            <input type="url" name="website" id="website" class="form-control" placeholder="https://example.com">
                        </div>
                    </div>

                    <button type="submit" class="btn"><i class="fas fa-paper-plane"></i> Submit Information</button>
                </form>
            </div>
        </div>

        <?php if ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
            <div class="result-section">
                <?php if (!empty($errors)): ?>
                    <div class="errors">
                        <h3><i class="fas fa-exclamation-triangle"></i> Validation Errors</h3>
                        <?php foreach ($errors as $err): ?>
                            <div class="error-item">
                                <i class="fas fa-times-circle"></i> <?php echo $err; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="success">
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <h3>Success! All inputs are valid.</h3>
                            <p>Your information has been processed successfully.</p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-clipboard-check"></i> Submitted Information
                        </div>
                        <div class="card-body">
                            <div class="result-box">
                                <div class="result-grid">
                                    <?php foreach ($result as $key => $value): ?>
                                        <div class="result-item">
                                            <h4><?php echo ucfirst($key); ?></h4>
                                            <p><?php echo htmlentities($value); ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="footer">
            <p>PHP Form Validation Example | Enhanced UI/UX Design</p>
            <p>Form sanitizes and validates: Name, Email, Age, and Website URL</p>
        </div>
    </div>
</body>

</html>