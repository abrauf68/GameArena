<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internet Speed Checker</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Orbitron', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #0a0a23;
            overflow: hidden;
        }

        .container {
            background: linear-gradient(145deg, #1a1a3d, #2a2a5e);
            border: 2px solid #00f0ff;
            border-radius: 25px;
            padding: 40px;
            width: 90%;
            max-width: 600px;
            text-align: center;
            box-shadow: 0 0 50px rgba(0, 240, 255, 0.3), inset 0 0 10px rgba(0, 240, 255, 0.5);
            position: relative;
            overflow: hidden;
        }

        /* .container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(0, 240, 255, 0.2) 0%, transparent 70%);
            animation: pulse 10s infinite;
        } */

        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.2); opacity: 0.5; }
            100% { transform: scale(1); opacity: 0.3; }
        }

        h1 {
            font-size: 2.5em;
            color: #00f0ff;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 20px;
            text-shadow: 0 0 10px #00f0ff;
        }

        .loader {
            position: relative;
            width: 200px;
            height: 200px;
            margin: 0 auto 20px;
        }

        .loader-circle {
            width: 100%;
            height: 100%;
            border: 10px solid transparent;
            border-top-color: #00f0ff;
            border-right-color: #ff00ff;
            border-radius: 50%;
            position: absolute;
        }

        .loader-circle.inner {
            width: 160px;
            height: 160px;
            border: 8px solid transparent;
            border-bottom-color: #00ff00;
            border-left-color: #ff00ff;
            top: 20px;
            left: 20px;
        }

        .animate-spin {
            animation: spin 2s linear infinite;
        }

        .animate-spin-reverse {
            animation: spin-reverse 1.5s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes spin-reverse {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(-360deg); }
        }

        .loader-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.2em;
            color: #fff;
            text-shadow: 0 0 10px #00f0ff;
        }

        .speed-display {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
        }

        .speed-box {
            background: rgba(0, 240, 255, 0.1);
            padding: 15px;
            border-radius: 10px;
            width: 45%;
            box-shadow: 0 0 15px rgba(0, 240, 255, 0.3);
        }

        .speed-box h3 {
            font-size: 1.2em;
            color: #00f0ff;
            margin-bottom: 10px;
        }

        .speed-box p {
            font-size: 2em;
            color: #00ff00;
            text-shadow: 0 0 10px #00ff00;
        }

        .speed-box p span {
            font-size: 0.5em;
            color: #00f0ff;
        }

        .status {
            font-size: 1.2em;
            color: #fff;
            margin: 20px 0;
            text-shadow: 0 0 5px #fff;
        }

        .progress-bar {
            width: 80%;
            height: 12px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            margin: 20px auto;
            overflow: hidden;
            border: 1px solid #00f0ff;
            display: none;
        }

        .progress {
            width: 0;
            height: 100%;
            background: linear-gradient(90deg, #00f0ff, #ff00ff);
            transition: width 0.3s ease;
        }

        button {
            background: linear-gradient(45deg, #ff00ff, #00f0ff);
            border: none;
            padding: 15px 40px;
            font-size: 1.3em;
            color: #fff;
            border-radius: 50px;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 0 20px #00f0ff;
        }

        button:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 0 30px #00f0ff;
        }

        button:active:not(:disabled) {
            transform: translateY(0);
            box-shadow: 0 0 10px #00f0ff;
        }

        button:disabled {
            background: #555;
            cursor: not-allowed;
            box-shadow: none;
        }

        @media (max-width: 500px) {
            h1 {
                font-size: 1.8em;
            }

            .loader {
                width: 160px;
                height: 160px;
            }

            .loader-circle.inner {
                width: 120px;
                height: 120px;
                top: 20px;
                left: 20px;
            }

            .speed-box {
                width: 48%;
            }

            .speed-box p {
                font-size: 1.5em;
            }

            button {
                padding: 12px 30px;
                font-size: 1em;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>SpeedX Tester</h1>
        <div class="loader">
            <div class="loader-circle" id="outerCircle"></div>
            <div class="loader-circle inner" id="innerCircle"></div>
            <div class="loader-text" id="loaderText">Ready</div>
        </div>
        <div class="speed-display">
            <div class="speed-box">
                <h3>Download</h3>
                <p id="downloadSpeed">0 <span>Mbps</span></p>
            </div>
            <div class="speed-box">
                <h3>Upload</h3>
                <p id="uploadSpeed">0 <span>Mbps</span></p>
            </div>
        </div>
        <div class="status" id="status">Click to Start Test</div>
        <div class="progress-bar" id="progressBar">
            <div class="progress" id="progress"></div>
        </div>
        <button id="startButton" onclick="startSpeedTest()">Start Test</button>
    </div>

    <script>
        const loaderText = document.getElementById('loaderText');
        const outerCircle = document.getElementById('outerCircle');
        const innerCircle = document.getElementById('innerCircle');
        const downloadSpeed = document.getElementById('downloadSpeed');
        const uploadSpeed = document.getElementById('uploadSpeed');
        const status = document.getElementById('status');
        const progressBar = document.getElementById('progressBar');
        const progress = document.getElementById('progress');
        const testButton = document.getElementById('startButton');

        // Ensure button is clickable on page load
        testButton.disabled = false;
        testButton.style.cursor = 'pointer';
        console.log('Page loaded, button enabled');

        // Stop loader animation initially
        outerCircle.classList.remove('animate-spin');
        innerCircle.classList.remove('animate-spin-reverse');

        async function startSpeedTest() {
            console.log('Test started');
            testButton.disabled = true;
            testButton.style.cursor = 'not-allowed';
            status.textContent = 'Testing Download...';
            progressBar.style.display = 'block';
            progress.style.width = '0%';
            loaderText.textContent = 'Testing...';

            // Start loader animation
            outerCircle.classList.add('animate-spin');
            innerCircle.classList.add('animate-spin-reverse');

            // Use a reliable test file from Lorem Picsum (~1MB)
            const testFile = 'https://picsum.photos/2000/2000.jpg';
            const fileSizeMB = 1.0; // Approximate file size in MB
            const testDuration = 30; // Total test duration in seconds (15s download + 15s upload)

            try {
                // Download Test
                let totalBitsLoaded = 0;
                let testCount = 0;
                let startTime = performance.now();

                let progressInterval = setInterval(() => {
                    let width = parseFloat(progress.style.width) || 0;
                    if (width < 45) {
                        progress.style.width = `${width + 5}%`;
                    }
                }, 1500);

                while ((performance.now() - startTime) / 1000 < testDuration / 2) {
                    const iterationStart = performance.now();
                    const response = await fetch(testFile, { cache: 'no-store' });
                    if (!response.ok) {
                        console.error(`Download failed: HTTP ${response.status}`);
                        throw new Error('Download failed');
                    }
                    const data = await response.blob();
                    const iterationEnd = performance.now();

                    const duration = (iterationEnd - iterationStart) / 1000;
                    const bitsLoaded = fileSizeMB * 8 * 1024 * 1024;
                    totalBitsLoaded += bitsLoaded;
                    testCount++;
                    console.log(`Download iteration ${testCount}: ${duration}s`);
                }

                const downloadDuration = (performance.now() - startTime) / 1000;
                const downloadSpeedBps = totalBitsLoaded / downloadDuration;
                const downloadSpeedMbps = (downloadSpeedBps / (1024 * 1024)).toFixed(2);
                downloadSpeed.innerHTML = `${downloadSpeedMbps} <span>Mbps</span>`;
                status.textContent = 'Testing Upload...';
                progress.style.width = '50%';

                // Upload Test (Simulated locally)
                totalBitsLoaded = 0;
                testCount = 0;
                startTime = performance.now();
                const uploadData = new Blob([new ArrayBuffer(fileSizeMB * 1024 * 1024)]); // 1MB blob

                while ((performance.now() - startTime) / 1000 < testDuration / 2) {
                    const iterationStart = performance.now();
                    await new Promise(resolve => setTimeout(resolve, 1000)); // Simulate network delay
                    const iterationEnd = performance.now();

                    const duration = (iterationEnd - iterationStart) / 1000;
                    const bitsLoaded = fileSizeMB * 8 * 1024 * 1024;
                    totalBitsLoaded += bitsLoaded;
                    testCount++;
                    console.log(`Upload iteration ${testCount}: ${duration}s`);
                }

                clearInterval(progressInterval);
                progress.style.width = '100%';

                const uploadDuration = (performance.now() - startTime) / 1000;
                const uploadSpeedBps = totalBitsLoaded / uploadDuration;
                const uploadSpeedMbps = (uploadSpeedBps / (1024 * 1024)).toFixed(2);
                uploadSpeed.innerHTML = `${uploadSpeedMbps} <span>Mbps</span>`;
                status.textContent = 'Test Complete!';
                loaderText.textContent = 'Done';

                // Stop loader animation
                outerCircle.classList.remove('animate-spin');
                innerCircle.classList.remove('animate-spin-reverse');

                // Reset UI and re-enable button
                setTimeout(() => {
                    progressBar.style.display = 'none';
                    progress.style.width = '0%';
                    testButton.disabled = false;
                    testButton.style.cursor = 'pointer';
                    status.textContent = 'Click to Start Test';
                    loaderText.textContent = 'Ready';
                    console.log('Test completed, button re-enabled');
                }, 3000);
            } catch (error) {
                console.error('Test error:', error.message);
                status.textContent = 'Test Failed. Please try again.';
                progressBar.style.display = 'none';
                progress.style.width = '0%';
                testButton.disabled = false;
                testButton.style.cursor = 'pointer';
                loaderText.textContent = 'Error';
                outerCircle.classList.remove('animate-spin');
                innerCircle.classList.remove('animate-spin-reverse');
            }
        }
    </script>
</body>
</html>