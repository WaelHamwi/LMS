<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Role</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 120vh;
            padding: 20px;
            color: #4a4a4a;
        }

        .container {
            max-width: 1000px;
            width: 100%;
            background-color: #ffffff;
            padding: 50px;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: auto;
        }

        .container h1 {
            font-size: 2.6rem;
            font-weight: 700;
            color: #2d3e50;
            margin-bottom: 40px;
            text-transform: uppercase;
        }

        .roles {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-evenly;
            gap: 30px;
        }

        .role-card {
            width: 240px;
            text-align: center;
            padding: 30px 20px;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }

        .role-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        }

        .role-icon {
            width: 60px;
            height: 60px;
            margin-bottom: 20px;
            object-fit: contain;
            transition: transform 0.3s ease-in-out;
        }

        .role-card:hover .role-icon {
            transform: scale(1.1);
        }

        .role-name {
            font-size: 1.4rem;
            font-weight: 500;
            color: #2d3e50;
            margin-bottom: 15px;
        }

        .role-desc {
            font-size: 1rem;
            color: #7d8a92;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        .role-btn {
            padding: 12px 20px;
            font-size: 1rem;
            color: #ffffff;
            background-color: #5d6d7e;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            letter-spacing: 1px;
            transition: background-color 0.3s ease;
        }

        .role-btn:hover {
            background-color: #34495e;
        }

        @media (max-width: 768px) {
            .roles {
                flex-direction: column;
                gap: 20px;
            }

            .role-card {
                width: 90%;
                padding: 30px;
            }

            .role-icon {
                width: 55px;
                height: 55px;
            }

            .role-name {
                font-size: 1.3rem;
            }

            .role-btn {
                font-size: 1.1rem;
                padding: 14px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Select Your Role</h1>
        <div class="roles">
            <div class="role-card">
                <img src="{{ asset('assets/img/admin-icon.png') }}" alt="Admin" class="role-icon">
                <div class="role-name">Admin</div>
                <div class="role-desc">Oversee platform operations and manage users.</div>
                <!-- This link should correctly include the 'role' query parameter -->
                <a href="{{ route('login') }}?role=admin" class="role-btn">Login as Admin</a>
            </div>

            <div class="role-card">
                <img src="{{ asset('assets/img/teacher-icon.png') }}" alt="Teacher" class="role-icon">
                <div class="role-name">Teacher</div>
                <div class="role-desc">Facilitate learning, assign tasks, and manage students.</div>
                <a href="{{ route('login') }}?role=teacher" class="role-btn">Login as Teacher</a>
            </div>

            <div class="role-card">
                <img src="{{ asset('assets/img/parent-icon.png') }}" alt="Parent" class="role-icon">
                <div class="role-name">Parent</div>
                <div class="role-desc">Monitor and support your child's academic progress.</div>
                <a href="{{ route('login') }}?role=parent" class="role-btn">Login as Parent</a>
            </div>

            <div class="role-card">
                <img src="{{ asset('assets/img/student-icon.png') }}" alt="Student" class="role-icon">
                <div class="role-name">Student</div>
                <div class="role-desc">Engage with lessons, access resources, and track progress.</div>
                <a href="{{ route('login') }}?role=student" class="role-btn">Login as Student</a>
            </div>
        </div>

    </div>
</body>

</html>