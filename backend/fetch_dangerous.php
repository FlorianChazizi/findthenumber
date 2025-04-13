<?php

$danerousQuery = "
    SELECT 
        numbers.number,
        c.comment,
        c.created_at
    FROM comments c
    JOIN numbers ON c.number_id = numbers.id
    WHERE c.rank = 'dangerous'
    AND c.created_at = (
        SELECT MAX(c2.created_at)
        FROM comments c2
        WHERE c2.number_id = c.number_id
        AND c2.rank = 'dangerous'
    )
    ORDER BY c.created_at DESC
    LIMIT 5
";

$dangerousResult = $conn->query($danerousQuery);
?>
