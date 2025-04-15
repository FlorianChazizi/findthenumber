document.addEventListener('DOMContentLoaded', function () {
    const rankOptions = document.querySelectorAll('.rank-wrapper-1');
    const submitButton = document.querySelector('.submit-button');
    const textarea = document.querySelector('.txtarea');

    if (!rankOptions.length || !submitButton || !textarea) return;

    let selectedRank = null;

    const preChecked = document.querySelector('input.rank:checked');
    if (preChecked) {
        selectedRank = preChecked.value;
    }

    checkFormValidity();

    rankOptions.forEach(option => {
        option.addEventListener('click', () => {
            selectedRank = option.dataset.value;

            rankOptions.forEach(opt => {
                const radio = opt.querySelector('input.rank');
                if (!radio) return;
                if (opt === option) {
                    opt.classList.add('selected');
                    radio.checked = true;
                } else {
                    opt.classList.remove('selected');
                    radio.checked = false;
                }
            });

            checkFormValidity();
        });
    });

    textarea.addEventListener('input', checkFormValidity);

    function checkFormValidity() {
        const comment = textarea.value.trim();
        const isValid = comment.length > 0 && selectedRank !== null;
        submitButton.disabled = !isValid;
    }
});
