<?php

require_once "../core/core.php";

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register Customer</title>

    <link rel="stylesheet" href="../css/style.css">

    <style>
        body {
            margin: 0;
            background: linear-gradient(135deg, #fff5f8, #ffe4ef);
        }

        .register-page {
            min-height: calc(100vh - 80px);
            padding: 45px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-container {
            width: 100%;
            max-width: 1050px;
            min-height: 650px;
            background: white;
            border-radius: 28px;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            box-shadow: 0 20px 60px rgba(214, 51, 132, 0.18);
        }

        .register-form-side {
            padding: 45px 50px;
        }

        .register-header {
            margin-bottom: 28px;
        }

        .register-header h1 {
            margin: 0 0 8px;
            color: #d63384;
            font-size: 32px;
        }

        .register-header p {
            margin: 0;
            color: #777;
            font-size: 15px;
        }

        .register-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 17px 22px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            margin-bottom: 6px;
            font-size: 14px;
            font-weight: 600;
            color: #444;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 11px 13px;
            border: 1px solid #e0d5da;
            border-radius: 9px;
            font-size: 14px;
            background: #fff;
            outline: none;
            transition: 0.25s;
            box-sizing: border-box;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #d63384;
            box-shadow: 0 0 0 3px rgba(214, 51, 132, 0.1);
        }

        .form-group input[type="file"] {
            padding: 9px;
        }

        .register-button {
            grid-column: 1 / -1;
            margin-top: 5px;
        }

        .register-button button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #d63384, #ed5b9d);
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.25s;
            box-shadow: 0 8px 18px rgba(214, 51, 132, 0.2);
        }

        .register-button button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(214, 51, 132, 0.3);
        }

        .register-error {
            background: #ffe5ec;
            color: #b4234d;
            padding: 11px 14px;
            border-radius: 9px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .register-art {
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

        .art-content {
            position: relative;
            z-index: 5;
            text-align: center;
            padding: 40px;
        }

        .art-content h2 {
            font-size: 32px;
            margin: 0 0 14px;
            letter-spacing: 0.5px;
        }

        .art-content p {
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

        @media (max-width: 850px) {
            .register-container {
                grid-template-columns: 1fr;
            }

            .register-art {
                min-height: 300px;
                order: -1;
            }

            .register-form-side {
                padding: 35px 25px;
            }
        }

        @media (max-width: 600px) {
            .register-page {
                padding: 20px 12px;
            }

            .register-form {
                grid-template-columns: 1fr;
            }

            .form-group.full-width,
            .register-button {
                grid-column: auto;
            }

            .register-header h1 {
                font-size: 27px;
            }

            .register-art {
                min-height: 270px;
            }
        }
    </style>
</head>

<body>

<?php require_once __DIR__ . "/layout/header.php"; ?>

<div class="register-page">

    <div class="register-container">

        <div class="register-form-side">

            <div class="register-header">
                <h1>Create Your Account</h1>
                <p>Fill in your details to get started.</p>
            </div>

            <?php
            if (isset($_SESSION['error'])) {
                echo '<div class="register-error">' . htmlspecialchars($_SESSION['error']) . '</div>';
                unset($_SESSION['error']);
            }
            ?>

            <form
                class="register-form"
                action="../actions/register_action.php"
                method="POST"
                enctype="multipart/form-data"
            >

                <div class="form-group">
                    <label for="customer_name">Full Name</label>
                    <input
                        type="text"
                        name="customer_name"
                        id="customer_name"
                        required
                    >
                </div>

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

                <div class="form-group">
                    <label for="customer_country">Country</label>
                    <select
                        name="customer_country"
                        id="customer_country"
                        required
                    >
                        <option value="">Select Country</option>
                        <option value="Ghana">Ghana</option>
                        <option value="Niger">Niger</option>
                        <option value="Nigeria">Nigeria</option>
                        <option value="Benin">Benin</option>
                        <option value="Togo">Togo</option>
                        <option value="Burkina Faso">Burkina Faso</option>
                        <option value="Mali">Mali</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="customer_city">City</label>
                    <input
                        type="text"
                        name="customer_city"
                        id="customer_city"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="customer_contact">Contact Number</label>
                    <input
                        type="text"
                        name="customer_contact"
                        id="customer_contact"
                        required
                    >
                </div>

                <div class="form-group full-width">
                    <label for="customer_address">Address</label>
                    <input
                        type="text"
                        name="customer_address"
                        id="customer_address"
                        required
                    >
                </div>

                <div class="form-group full-width">
                    <label for="customer_image">Profile Image (optional)</label>
                    <input
                        type="file"
                        name="customer_image"
                        id="customer_image"
                        accept="image/*"
                    >
                </div>

                <div class="register-button">
                    <button type="submit">Create Account</button>
                </div>

            </form>

        </div>

        <div class="register-art">

            <div class="bubble bubble-one"></div>
            <div class="bubble bubble-two"></div>
            <div class="bubble bubble-three"></div>
            <div class="bubble bubble-four"></div>
            <div class="bubble bubble-five"></div>

            <div class="art-shape"></div>
            <div class="art-shape art-shape-two"></div>

            <div class="art-content">

                <div class="welcome-line"></div>

                <h2>Welcome</h2>

              
            </div>

        </div>

    </div>

</div>

<script src="../js/validate.js"></script>

<?php require_once __DIR__ . "/layout/footer.php"; ?>

</body>
</html>