<?php
include 'db_config.php';
include 'backend/handle_number_search.php';
include 'backend/fetch_dangerous.php';
include 'backend/fetch_recent_reviews.php';
include 'backend/fetch_annoying.php';
// include 'backend/mostviewed.php';
// include 'backend/lastviewed.php'; 
// include 'backend/lastcreated.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STN - Search The Number</title>
    <link rel="stylesheet" href="styles/index.css">
    <script defer src="scripts/numtable.js"></script>

</head>

<div>
    <!-- Header -->
    <div class="body-content">
        <div class="header-wrapper">
            <div class="header-bg">
                <div class="header">
                    <a href="index.php"><img src="assets/searchLogo.svg" alt="Logo" class="logo"></a>
                    <form method="POST" action="" class="search-wrapper">
                        <input class="searchBar" inputmode="numeric" pattern="[0-9]*" type="text" name="number"
                            placeholder="Search a number" required>
                        <button type="submit" class="searchButton">
                            <img src="assets/search-icon.svg" class="searchIcon" alt="Search" class="search-icon">
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Body -->
    <div class="main-wrapper">
        <!-- Recent Reviews -->
        <div class="content">
            <h2 className='body-title'>Πρόσφατες Αξιολογήσεις των αριθμών</h2>
            <?php if ($recentResult->num_rows > 0): ?>

                <div class="recent-reviews">
                    <?php while ($row = $recentResult->fetch_assoc()): ?>
                        <a href="number.php?number=<?php echo urlencode($row['number']); ?>" class="review-item">
                            <div class="comment-items">
                                <strong class="number">
                                    <?php echo htmlspecialchars($row['number']); ?>
                                </strong>
                                <?php if (!empty($row['comment'])): ?>
                                    <?php
                                    $rank = htmlspecialchars($row['rank']);
                                    $rankClass = 'rank-default';

                                    if ($rank === 'useful') {
                                        $rankClass = 'rank-useful';
                                    } elseif ($rank === 'safe') {
                                        $rankClass = 'rank-safe';
                                    } elseif ($rank === 'neutral') {
                                        $rankClass = 'rank-neutral';
                                    } elseif ($rank === 'annoying') {
                                        $rankClass = 'rank-annoying';
                                    } elseif ($rank === 'dangerous') {
                                        $rankClass = 'rank-dangerous';
                                    }
                                    ?>
                                    <span class="rank <?php echo $rankClass; ?>">
                                        <?php echo htmlspecialchars($row['rank']); ?>
                                    </span>
                                    <p class="comment">
                                        <?php echo htmlspecialchars($row['comment']); ?>
                                    </p>
                                <?php else: ?>
                                    <p class="no-comment">No comments yet.</p>
                                <?php endif; ?>
                            </div>
                            </a>
                        <?php endwhile; ?>
                    
                </div>

            <?php else: ?>
                <p>No recent reviews found.</p>
            <?php endif; ?>
        </div>

        
        <!-- Sidebar -->
        <div class="sidebar">
            <h2 class="side-header">Ενοχλητικοί Αριθμοί</h2>
            <?php if ($annoyingResult && $annoyingResult->num_rows > 0): ?>
                <?php while ($row = $annoyingResult->fetch_assoc()): ?>

                    <div class="instances">
                        <strong>
                            <a class="arithmos" href="number.php?number=<?php echo urlencode($row['number']); ?>">
                                <?php echo htmlspecialchars($row['number']); ?> </a>
                        </strong>
                        <p class="desc"><?php echo htmlspecialchars($row['comment']); ?></p>
                    <?php endwhile; ?>

                </div>
            <?php else: ?>
                <p>No annoying numbers found yet.</p>
            <?php endif; ?>

            <h2 class="side-header">Επικίνδυνοι αριθμοί </h2>
            <?php if ($dangerousResult && $dangerousResult->num_rows > 0): ?>
                <?php while ($row = $dangerousResult->fetch_assoc()): ?>
                    <div class="instances">
                        <strong>
                            <a class="arithmos" href="number.php?number=<?php echo urlencode($row['number']); ?>">
                                <?php echo htmlspecialchars($row['number']); ?>
                            </a>
                        </strong>
                        <p class="desc"><?php echo htmlspecialchars($row['comment']); ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No dangerous numbers found yet.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- numtable -->
    <div class="table-wrapper">
        <h1 class="table-title">Αριθμοί τηλεφώνου</h1>

        <!-- Tabs Navigation -->
        <ul id="tabs" class="table-tabs">
            <li data-tab="mostWanted" class="active">Οι πιο περιζήτητοι αριθμοί</li>
            <li data-tab="recentlyAdded">Πρόσφατα προστέθηκαν</li>
            <li data-tab="recentlySearched">Πρόσφατα αναζητήθηκαν</li>
        </ul>

        <!-- Content area that JS updates -->
        <div id="tab-content" class="tab-content"></div>
    </div>

</body>

</html>