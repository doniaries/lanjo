const http = require('http');

const url = 'http://127.0.0.1:8000';
const concurrency = 100;
const duration = 10000; // 10 seconds

let completedRequests = 0;
let failedRequests = 0;
let totalTime = 0;
let startTime = Date.now();
let activeRequests = 0;
let running = true;

const makeRequest = () => {
    if (!running) return;

    const reqStart = Date.now();
    activeRequests++;

    http.get(url, (res) => {
        res.on('data', () => {}); // Consume data
        res.on('end', () => {
            const reqEnd = Date.now();
            totalTime += (reqEnd - reqStart);
            completedRequests++;
            activeRequests--;
            
            if (running) makeRequest();
        });
    }).on('error', (e) => {
        failedRequests++;
        activeRequests--;
        if (running) makeRequest();
    });
};

console.log(`Starting load test on ${url} with ${concurrency} concurrent users...`);

// Start concurrent requests
for (let i = 0; i < concurrency; i++) {
    makeRequest();
}

// Stop after duration
setTimeout(() => {
    running = false;
    const endTime = Date.now();
    const actualDuration = (endTime - startTime) / 1000;
    const avgResponseTime = completedRequests > 0 ? (totalTime / completedRequests) : 0;
    const reqPerSec = completedRequests / actualDuration;

    console.log('\nLoad Test Results:');
    console.log('------------------');
    console.log(`Duration: ${actualDuration.toFixed(2)}s`);
    console.log(`Total Requests: ${completedRequests}`);
    console.log(`Failed Requests: ${failedRequests}`);
    console.log(`Requests/sec: ${reqPerSec.toFixed(2)}`);
    console.log(`Avg Response Time: ${avgResponseTime.toFixed(2)}ms`); // Changed to ms
    
    process.exit(0);
}, duration);
