$(document).ready(function() {
    // Track the number of selected players for each type
    let batsmenCount = 0;
    let allRoundersCount = 0;
    let bowlersCount = 0;

    // Total points selected by the user
    let totalPoints = 0;

    // Handle checkbox change event
    $(document).on('change', '.player-checkbox', function() {
        const checkbox = $(this);
        const playerId = checkbox.val();
        const playerType = checkbox.data('type');
        const points = parseInt(checkbox.data('points'));

        if (checkbox.prop('checked')) {
            // Increment count based on player type
            if (playerType === 'Batsman') {
                batsmenCount++;
            } else if (playerType === 'AllRounder') {
                allRoundersCount++;
            } else if (playerType === 'Bowler') {
                bowlersCount++;
            }

            // Check if maximum limit reached
            if (batsmenCount > 5 || allRoundersCount > 2 || bowlersCount > 4) {
                alert('Maximum limit reached for selected player type.');
                checkbox.prop('checked', false); // Uncheck the checkbox
                // Decrement count
                if (playerType === 'Batsman') {
                    batsmenCount--;
                } else if (playerType === 'AllRounder') {
                    allRoundersCount--;
                } else if (playerType === 'Bowler') {
                    bowlersCount--;
                }
            } else {
                // Increment total points
                totalPoints += points;
                // Check if total points exceed 100
                if (totalPoints > 100) {
                    alert('Total points exceed 100.');
                    checkbox.prop('checked', false); // Uncheck the checkbox
                    // Decrement count
                    if (playerType === 'Batsman') {
                        batsmenCount--;
                    } else if (playerType === 'AllRounder') {
                        allRoundersCount--;
                    } else if (playerType === 'Bowler') {
                        bowlersCount--;
                    }
                    // Decrement total points
                    totalPoints -= points;
                }
            }
        } else {
            // Decrement count based on player type
            if (playerType === 'Batsman') {
                batsmenCount--;
            } else if (playerType === 'AllRounder') {
                allRoundersCount--;
            } else if (playerType === 'Bowler') {
                bowlersCount--;
            }
            // Decrement total points
            totalPoints -= points;
        }

        // Enable or disable submit button based on total selected players and total points
        const totalSelected = batsmenCount + allRoundersCount + bowlersCount;
        $('#submit-btn').prop('disabled', totalSelected !== 11 || totalPoints > 100);
    });

    // Handle form submission with AJAX
    $('#team-form').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        const formData = $(this).serialize(); // Serialize form data
        $.ajax({
            url: 'save_team.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                // Handle response from server, e.g., display success message or redirect
                alert(response); // For demonstration purposes
                window.location.href = 'view_team.php'; // Redirect to view team page
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(xhr.responseText);
            }
        });
    });
});
