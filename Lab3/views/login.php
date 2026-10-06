<?php

require_once "../core/core.php";

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log In</title>

    <link rel="stylesheet" href="../css/style.css">

    <style>
        body {
            margin: 0;
            background: linear-gradient(135deg, #fff5f8, #ffe4ef);
        }

        .login-page {
            min-height: calc(100vh - 80px);
            padding: 45px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            width: 100%;
            max-width: 1000px;
            min-height: 570px;
            background: white;
            border-radius: 28px;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 0.9fr;
            box-shadow: 0 20px 60px rgba(214, 51, 132, 0.18);
        }

        .login-form-side {
            padding: 70px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            margin-bottom: 32px;
        }

        .login-header h1 {
            margin: 0 0 10px;
            color: #d63384;
            font-size: 34px;
        }

        .login-header p {
            margin: 0;
            color: #777;
            font-size: 15px;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: 600;
            color: #444;
        }

        .form-group input {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #e0d5da;
            border-radius: 10px;
            font-size: 15px;
            background: #fff;
            outline: none;
            transition: 0.25s;
            box-sizing: border-box;
        }

        .form-group input:focus {
            border-color: #d63384;
            box-shadow: 0 0 0 3px rgba(214, 51, 132, 0.1);
        }

        .login-button {
            margin-top: 5px;
        }

        .login-button button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #d63384, #ed5b9d);
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.25s;
            box-shadow: 0 8px 18px rgba(214, 51, 132, 0.2);
        }

        .login-button button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(214, 51, 132, 0.3);
        }

        .login-register {
            margin-top: 25px;
            text-align: center;
            color: #777;
            font-size: 14px;
        }

        .login-register a {
            color: #d63384;
            font-weight: 600;
            text-decoration: none;
        }

        .login-register a:hover {
            text-decoration: underline;
        }

        .error-message {
            background: #ffe5ec;
            color: #b4234d;
            padding: 11px 14px;
            border-radius: 9px;
            margin: 0 0 20px;
            font-size: 14px;
        }

        .login-art {
            position: relative;
            overflow: hidden;
            background: linear-gradient(145deg, #d63384, #a91f65);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .bubble {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.13);
            animation: bubbleFloat 8s ease-in-out infinite;
        }

        .bubble-one {
            width: 230px;
            height: 230px;
            top: -70px;
            right: -70px;
        }

        .bubble-two {
            width: 140px;
            height: 140px;
            bottom: 30px;
            left: -50px;
            animation-delay: 1.5s;
        }

        .bubble-three {
            width: 70px;
            height: 70px;
            top: 25%;
            right: 18%;
            background: rgba(255, 255, 255, 0.2);
            animation-delay: 3s;
        }

        .bubble-four {
            width: 35px;
            height: 35px;
            top: 58%;
            left: 18%;
            background: rgba(255, 255, 255, 0.3);
            animation-delay: 2s;
        }

        .bubble-five {
            width: 20px;
            height: 20px;
            bottom: 20%;
            right: 30%;
            background: rgba(255, 255, 255, 0.4);
            animation-delay: 4s;
        }

        .art-shape {
            position: absolute;
            width: 180px;
            height: 180px;
            border: 2px solid rgba(255, 255, 255, 0.18);
            border-radius: 35% 65% 60% 40%;
            transform: rotate(25deg);
            animation: shapeRotate 12s linear infinite;
        }

        .art-shape-two {
            width: 120px;
            height: 120px;
            border-radius: 60% 40% 35% 65%;
            transform: rotate(-20deg);
            animation: shapeRotateReverse 10s linear infinite;
        }

        .login-art-content {
            position: relative;
            z-index: 5;
            text-align: center;
            padding: 40px;
        }

        .login-art-content h2 {
            font-size: 32px;
            margin: 0 0 14px;
            letter-spacing: 0.5px;
        }

        .login-art-content p {
            font-size: 15px;
            line-height: 1.8;
            opacity: 0.9;
            max-width: 280px;
            margin: auto;
        }

        .welcome-line {
            width: 45px;
            height: 3px;
            border-radius: 5px;
            background: white;
            margin: 0 auto 20px;
            animation: linePulse 2s ease-in-out infinite;
        }

        @keyframes bubbleFloat {
            0%, 100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-25px) scale(1.06);
            }
        }

        @keyframes shapeRotate {
            0% {
                transform: rotate(25deg);
            }

            50% {
                transform: rotate(205deg) scale(1.08);
            }

            100% {
                transform: rotate(385deg);
            }
        }

        @keyframes shapeRotateReverse {
            0% {
                transform: rotate(-20deg);
            }

            50% {
                transform: rotate(-200deg) scale(0.9);
            }

            100% {
                transform: rotate(-380deg);
            }
        }

        @keyframes linePulse {
            0%, 100% {
                opacity: 0.5;
                transform: scaleX(0.8);
            }

            50% {
                opacity: 1;
                transform: scaleX(1.2);
            }
        }

        @media (max-width: 800px) {
            .login-container {
                grid-template-columns: 1fr;
            }

            .login-art {
                min-height: 280px;
                order: -1;
            }

            .login-form-side {
                padding: 45px 30px;
            }
        }

        @media (max-width: 500px) {
            .login-page {
                padding: 20px 12px;
            }

            .login-form-side {
                padding: 35px 22px;
            }

            .login-art {
                min-height: 250px;
            }

            .login-header h1 {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>

<?php require_once __DIR__ . "/layout/header.php"; ?>

<div class="login-page">

    <div class="login-container">

        <div class="login-form-side">

            <div class="login-header">
                <h1>Welcome Back</h1>
                <p>Log in to continue to your account.</p>
            </div>

            <?php
            if (!empty($_SESSION['error'])) {
                echo '<p class="error-message">'
                    . htmlspecialchars($_SESSION['error'])
                    . '</p>';

                unset($_SESSION['error']);
            }
            ?>

            <form
                class="login-form"
                action="../actions/login_action.php"
                method="POST"
            >

                <div class="form-group">
                    <label for="customer_email">Email</label>

                    <input
                        type="email"
                        name="customer_email"
                        id="customer_email"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="customer_pass">Password</label>

                    <input
                        type="password"
                        name="customer_pass"
                        id="customer_pass"
                        required
                    >
                </div>

                <div class="login-button">
                    <button type="submit">Log In</button>
                </div>

            </form>

            <p class="login-register">
                Don't have an account?
                <a href="register.php">Create one</a>
            </p>

        </div>

        <div class="login-art">

            <div class="bubble bubble-one"></div>
            <div class="bubble bubble-two"></div>
            <div class="bubble bubble-three"></div>
            <div class="bubble bubble-four"></div>
            <div class="bubble bubble-five"></div>

            <div class="art-shape"></div>
            <div class="art-shape art-shape-two"></div>

            <div class="login-art-content">

                <div class="welcome-line"></div>

                <h2>Good to See You</h2>

               

            </div>

        </div>

    </div>

</div>

<?php require_once __DIR__ . "/layout/footer.php"; ?>

</body>
</html>