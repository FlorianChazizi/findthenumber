<?php
$recentQuery = "
SELECT 
       comments.id AS comment_id,
       numbers.number, 
       comments.comment, 
       comments.rank, 
       comments.created_at
      FROM comments
      JOIN numbers ON comments.number_id = numbers.id
      ORDER BY comments.created_at DESC
      LIMIT 10
";

$recentResult = $conn->query($recentQuery);
?>
