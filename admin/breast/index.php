<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon - Breast Cancer Detection</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
        }

        .logo {
            width: 100px;
            height: 100px;
            background: #007acc;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        h1 {
            margin: 20px 0;
            font-size: 24px;
            color: #333;
        }

        p {
            font-size: 16px;
            color: #666;
        }

        .countdown {
            font-size: 36px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo"><img src="../../images/logo.png" alt=""></div>
        <h1>Coming Soon</h1>
        <p>We are working on a revolutionary breast cancer detection solution.</p>
        <div class="countdown" id="countdown">Launching in: 30 days</div>
    </div>

    <script>
        // Set the launch date for the countdown
        const launchDate = new Date('2023-11-27 00:00:00').getTime();

        // Update the countdown every second
        const countdown = document.getElementById('countdown');
        const timer = setInterval(function() {
            const currentDate = new Date().getTime();
            const distance = launchDate - currentDate;

            if (distance < 0) {
                clearInterval(timer);
                countdown.innerHTML = 'Now Live!';
            } else {
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                countdown.innerHTML = `Launching in: ${days} days, ${hours} hours, ${minutes} minutes, ${seconds} seconds`;
            }
        }, 1000);
    </script>
</body>
</html>
