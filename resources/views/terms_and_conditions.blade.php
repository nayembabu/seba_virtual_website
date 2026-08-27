<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        .status {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .uptime {
            text-align: center;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Server Status</h1>
        <div class="status" id="status">Loading...</div>
        <div class="uptime" id="uptime">Uptime: Loading...</div>
    </div>

    <script>
        fetch('http://igitalsonod.com.bd/uptime.txt')
    .then(response => response.text())
    .then(data => {
        console.log(data); // Log the fetched data to the console for debugging
        // Update your HTML with the fetched data
    })
    .catch(error => {
        console.error('Error fetching uptime.txt:', error);
    });


        // Initial fetch
        fetchServerStatus();

        // Fetch server status every 10 seconds
        setInterval(fetchServerStatus, 10000);
    </script>
</body>
</html>
