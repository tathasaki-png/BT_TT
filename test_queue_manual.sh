#!/bin/bash
# Test script: Register new user via form

echo "🧪 Testing Queue:Work → Send Mail Flow"
echo "======================================"
echo ""

# Variables
BASE_URL="http://localhost:8000"
EMAIL="testnewuser$(date +%s)@example.com"
NAME="Test User $(date +%H:%M:%S)"
PASSWORD="password123"

echo "📝 Test Case: Register New User via Form"
echo "────────────────────────────────────────"
echo "URL: $BASE_URL/register"
echo "Name: $NAME"
echo "Email: $EMAIL"
echo "Password: $PASSWORD"
echo ""

echo "⏳ Starting test..."
echo ""

# Check if server is running
echo "1️⃣  Checking server..."
if curl -s "$BASE_URL" > /dev/null; then
    echo "   ✅ Server is running"
else
    echo "   ❌ Server not running!"
    exit 1
fi

echo ""
echo "2️⃣  Checking queue worker..."
if pgrep -f "queue:work" > /dev/null; then
    echo "   ✅ Queue worker is running"
else
    echo "   ⚠️  Queue worker may not be running"
fi

echo ""
echo "3️⃣  Current Job Status:"
mysql -u root ttck_bai8 -e "SELECT status, COUNT(*) as count FROM job_logs GROUP BY status;"

echo ""
echo "4️⃣  To register new user:"
echo "   - Open: $BASE_URL/register"
echo "   - Fill form and submit"
echo "   - Watch queue worker in terminal"
echo "   - Refresh dashboard to see new job"
echo ""

echo "✅ Test setup complete!"
echo ""
echo "📊 Dashboard: $BASE_URL/dashboard"
echo "📋 Job Logs: $BASE_URL/job-logs"
