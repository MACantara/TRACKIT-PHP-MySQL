<!-- The Modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form action="includes/summary-report-generation.inc.php" method="post">
            <label for="events_semester">Semester:</label>
            <select id="events_semester" name="events_semester">
                <option value="" disabled selected>Select a Semester</option>
                <option value="1st Semester">1st Semester</option>
                <option value="2nd Semester">2nd Semester</option>
            </select>
            <?php
            // Fetch the distinct academic years from the database
            $sql = "SELECT DISTINCT events_academic_year FROM events ORDER BY events_academic_year DESC";
            $result = mysqli_query($conn, $sql);
            $years = mysqli_fetch_all($result, MYSQLI_ASSOC);
            ?>

            <label for="events_academic_year">Academic Year:</label>
            <select id="events_academic_year" name="events_academic_year">
                <option value="" disabled selected>Select an Academic Year</option>
                <?php foreach ($years as $year): ?>
                    <option value="<?php echo $year['events_academic_year']; ?>">
                        <?php echo $year['events_academic_year']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button class="button" type="submit">
            <i class='bi bi-file-earmark-text'></i> Generate Report
            </button>
        </form>
    </div>
</div>

<script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("openModalButton");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function () {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>