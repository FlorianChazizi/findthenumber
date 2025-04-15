<script>
document.addEventListener('DOMContentLoaded', function () {
    const rankOptions = document.querySelectorAll('.rank-wrapper-1');
    const submitButton = document.querySelector('.submit-button');
    const textarea = document.querySelector('.txtarea');

    // Safety checks
    if (!rankOptions.length || !submitButton || !textarea) return;

    // Default selection
    let selectedRank = 'annoying';
    updateSelection();

    rankOptions.forEach(option => {
        option.addEventListener('click', () => {
            selectedRank = option.dataset.value;
            updateSelection();
        });
    });

    textarea.addEventListener('input', () => {
        checkFormValidity();
    }); 

    function updateSelection() {
        rankOptions.forEach(option => {
            const radio = option.querySelector('input.rank');
            if (!radio) return;

            if (option.dataset.value === selectedRank) {
                option.classList.add('selected');
                radio.checked = true;
            } else {
                option.classList.remove('selected');
                radio.checked = false;
            }
        });
        checkFormValidity();
    }

    function checkFormValidity() {
        const comment = textarea.value.trim();
        submitButton.disabled = !comment || !selectedRank;
    }
});


</script>
