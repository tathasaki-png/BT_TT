<?php
$conn = new mysqli('127.0.0.1', 'root', '', 'khoahoc');
if ($conn->connect_errno) {
    echo 'DB connect error: ' . $conn->connect_error;
    exit(1);
}

$query = 'SELECT course_id, AVG(rating) avg_rating, COUNT(*) cnt FROM reviews GROUP BY course_id ORDER BY avg_rating DESC LIMIT 20';
$result = $conn->query($query);

if (!$result) {
    echo 'Query error: ' . $conn->error;
    exit(1);
}

while ($row = $result->fetch_assoc()) {
    echo 'course_id=' . $row['course_id'] . ' avg=' . $row['avg_rating'] . ' cnt=' . $row['cnt'] . "\n";
}
?>