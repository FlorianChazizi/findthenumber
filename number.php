<?php
include 'db_config.php';
include 'backend/number_data.php';
include 'backend/fetch_dangerous.php';
include 'backend/fetch_annoying.php';
include 'helpers/calculate_danger_rate.php';
include 'helpers/get_review_count.php';
include 'helpers/get_last_review_date.php';

$dangerRate = getDangerRate($conn, $number);
$reviewCount = getReviewCount($conn, $number);
$lastReviewDate = getLastReviewDate($conn, $number);


?>

<!DOCTYPE html>
<html>

<head>
    <title>Number <?php echo htmlspecialchars($number); ?></title>
    <link rel="stylesheet" href="styles/number.css">
    <link rel="stylesheet" href="styles/index.css">
    <script defer src="scripts/radiobuttons.js"></script>
</head>

<body>
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

    <!-- Number display -->
    <div class="title-container">
        <h2 class='title-h2'>Αριθμός τηλεφώνου:
            <span class='title-span'>
                <?php echo htmlspecialchars($data['number']); ?>
            </span>
        </h2>
    </div>


    <!-- body -->
    <div class="main-wrapper">
        <!-- statistics -->
        <div class="content statistics">
            <h2 class="body-title">
                Στατιστικά
            </h2>

            <table class="table">
                <thead>
                    <tr>
                        <th class='t-title' colspan="2">Αξιολόγηση</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Βαθμός του κινδύνου:</td>
                        <td>
                            <?php if ($dangerRate === null): ?>
                                <span class="danger-rate no-data">Χωρίς δεδομένα</span>
                            <?php else: ?>
                                <span class="danger-rate">
                                    <?php echo $dangerRate; ?>%
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Αριθμός αξιολογήσεων:</td>
                        <td>
                            <?php echo $reviewCount; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Τελευταία αξιολόγηση:</td>
                        <td class='t-td-cta'>
                            <?php echo $lastReviewDate ? date("d/m/Y H:i", strtotime($lastReviewDate)) : 'Δεν υπάρχουν ακόμα αξιολογήσεις'; ?>

                            <a href='#comment'><span class=' t-cta'>Προσθέστε ένα σχόλιο</span></a>
                        </td>
                    </tr>
                    <tr>
                        <th class='t-title-2' colspan="2">Εμφανίσεις</th>
                    </tr>
                    <tr>
                        <td>Αριθμός εμφανίσεων:</td>
                        <td>
                            <?php echo $data['views']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Τελευταία εμφάνιση:</td>
                        <td>
                            <?php echo $data['last_time_viewed']; ?>
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>

        <!-- add sidebar -->
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
                    </div>
                <?php endwhile; ?>
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

    <!-- add comment -->
    <div class="comment">
    <div class="form-container">
        <h2 class="form-title">Προσθήκη ενός σχολίου</h2>
        <div class="form">
            <form class="form-content" id="commentForm" method="POST">
                <div class="form-columns">
                    <div class="column-1">
                        <textarea
                            class="txtarea"
                            maxlength="200"
                            rows="8"
                            placeholder="Η εμπειρία σας με τον αριθμό <?php echo $number; ?>..."
                            name="comment"
                        ></textarea>
                    </div>
                    <div class="column-2">
                        <div class="select-wrapper" id="rankOptions">
                            <?php
                            $rankOptions = [
                                ['label' => 'Χρήσιμος', 'value' => 'useful', 'color' => '#23b54f'],
                                ['label' => 'Ασφαλής', 'value' => 'safe', 'color' => '#4d9981'],
                                ['label' => 'Ουδέτερος', 'value' => 'neutral', 'color' => '#169dc4'],
                                ['label' => 'Ενοχλητικός', 'value' => 'annoying', 'color' => '#e6523e'],
                                ['label' => 'Επικίνδυνος', 'value' => 'dangerous', 'color' => '#af1c6b'],
                            ];
                            foreach ($rankOptions as $index => $option) {
                                $selected = $option['value'] === 'useful' ? 'selected' : '';
                                echo "
                                <div class='rank-wrapper-1 $selected' data-color='{$option['color']}' data-value='{$option['value']}'>
                                    <label class='rank-1'>{$option['label']}</label>
                                    <input 
                                        name='rank' 
                                        type='radio' 
                                        class='rank' 
                                        value='{$option['value']}'
                                        " . ($selected ? "checked" : "") . "
                                    >
                                </div>
                                ";
                            }
                            ?>
                        </div>

                        <button 
                            type="submit"
                            class="submit-button"
                            disabled
                        >Υποβολή</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> 
    </div>



    <!-- comment list -->
    <div>
        <p> here we display the comments </p>
    </div>

    <!-- 
    <h1>Number: <?php echo htmlspecialchars($data['number']); ?></h1>
    <p><strong>Views:</strong> <?php echo $data['views']; ?></p>
    <p><strong>Created At:</strong> <?php echo $data['created_at']; ?></p>
    <p><strong>Updated At:</strong> <?php echo $data['updated_at']; ?></p>
    <p><strong>Last Time Viewed:</strong> <?php echo $data['last_time_viewed']; ?></p>
    <p><strong>Last Review:</strong> <?php echo $data['last_review'] ?: 'Never'; ?></p>
   -->
    <a href="index.php">← Back</a>
</body>

</html>

<?php $conn->close(); ?>